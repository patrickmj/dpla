
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>DPLA PHP Class Demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 20px;
        padding-bottom: 40px;
      }

      /* Custom container */
      .container-narrow {
        margin: 0 auto;
        max-width: 800px;
      }
      .container-narrow > hr {
        margin: 30px 0;
      }

      /* Main marketing message and sign up button */
      .jumbotron {
        margin: 60px 0;
        text-align: center;
      }
      .jumbotron h1 {
        font-size: 72px;
        line-height: 1;
      }
      .jumbotron .btn {
        font-size: 21px;
        padding: 14px 24px;
      }

      /* Supporting marketing content */
      .marketing {
        margin: 60px 0;
      }
      .marketing p + h4 {
        margin-top: 28px;
      }
    </style>
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="bootstrap/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="bootstrap/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="bootstrap/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="bootstrap/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="bootstrap/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>
    <span id="github">
      <a href="https://github.com/jblyberg/dpla"><img style="position: absolute; top: 0; right: 0; border: 0;" src="http://s3.amazonaws.com/github/ribbons/forkme_right_gray_6d6d6d.png" alt="Fork me on GitHub" /></a> 
    </span>

    <div class="container-narrow">

      <div class="masthead">
        <ul class="nav nav-pills pull-right">
          <li <? print (!$_GET['action'] || $_GET['action'] == 'search' || $_POST['action'] == 'search') ? 'class="active"' : ''?>><a href="?action=search">Item Search</a></li>
          <li <? print ($_GET['action'] == 'lookup' || $_POST['action'] == 'lookup') ? 'class="active"' : ''?>><a href="?action=lookup">Item Lookup</a></li>
        </ul>
        <h3 class="muted">DPLA API Search Prototype</h3>
      </div>

      <hr>

      <?if (!$_GET['action'] || $_GET['action'] == 'search' || $_POST['action'] == 'search') { ?>
      <div class="jumbotron">
        <h1>Search all the things:</h1>
        <p class="lead">
          <form method="post" action="<? print $_SERVER['PHP_SELF']; ?>">
          <fieldset>
            <input type="text" name="term" placeholder="What do you seek...?" value="<? print $_POST['term']; ?>">
             in <select name="field">
              <option value="all">Everything</option>
              <option value="title" <? print ($_POST['field'] == 'title' ? 'selected' : ''); ?>>Title</option>
              <option value="description" <? print ($_POST['field'] == 'description' ? 'selected' : ''); ?>>Description</option>
              <option value="subject" <? print ($_POST['field'] == 'subject' ? 'selected' : ''); ?>>Subject</option>
              <option value="dplacontributor" <? print ($_POST['field'] == 'dplacontributor' ? 'selected' : ''); ?>>DPLA Contributor</option>
              <option value="creator" <? print ($_POST['field'] == 'creator' ? 'selected' : ''); ?>>Creator</option>
              <option value="type" <? print ($_POST['field'] == 'type' ? 'selected' : ''); ?>>Type</option>
              <option value="publisher" <? print ($_POST['field'] == 'publisher' ? 'selected' : ''); ?>>Publisher</option>
              <option value="format" <? print ($_POST['field'] == 'format' ? 'selected' : ''); ?>>Format</option>
              <option value="rights" <? print ($_POST['field'] == 'rights' ? 'selected' : ''); ?>>Rights</option>
              <option value="contributor" <? print ($_POST['field'] == 'contributor' ? 'selected' : ''); ?>>Contributor</option>
              <option value="spatial" <? print ($_POST['field'] == 'spatial' ? 'selected' : ''); ?>>Spatial</option>
              <option value="ispartof" <? print ($_POST['field'] == 'ispartof' ? 'selected' : ''); ?>>Part of</option>
            </select>
            <div><button class="btn btn-large btn-success" type="submit" class="btn">Search</button></div>
            <input type="hidden" name="submitted" value="1">
            <input type="hidden" name="action" value="search">
          </fieldset>
          </form>
        </p>
      </div>
      <? } ?>

      <?if ($_GET['action'] == 'lookup' || $_POST['action'] == 'lookup') { ?>
      <?
        if ($_GET['itemID']) {
          $itemID = $_GET['itemID'];
        } else if ($_POST['itemID']) {
          $itemID = $_POST['itemID'];
        }
      ?>

      <div class="jumbotron">
        <h1>Lookup a thing:</h1>
        <p class="lead">
          <form method="post" action="<? print $_SERVER['PHP_SELF']; ?>">
          <fieldset>
            <input type="text" name="itemID" placeholder="Item ID" <? print ($itemID ? 'value="' . $itemID . '"' : '')?>>
            <div><a class="btn btn-large btn-success" href="#">Lookup</a></div>
            <input type="hidden" name="submitted" value="1">
            <input type="hidden" name="action" value="lookup">
          </fieldset>
          </form>
        </p>
      </div>
      <? } ?>

      <? if ($_POST['submitted'] || $itemID) { ?>

      <?
        require_once('dpla.php');
        require_once('kint/Kint.class.php');
        $dpla = new dpla;

        if ($_POST['action'] == 'search') {
          if (!$_POST['field'] || $_POST['field'] == 'all') {
            $searchtype = NULL;
          } else {
            $searchtype = $_POST['field'];
          }
          $term = $_POST['term'];

          $result = $dpla->search_item($term, $searchtype);

          if ($result['count'] > 0) {
            $result_str = 'Showing results ' . ($result['start'] + 1) . ' to ' . ($result['start'] + $result['limit']) . ' of ' . $result['count'];
          } else {
            $result_str = 'No results found';
          }
          $result_str .= ' searcing for "' . $term . '"';
          print '<div class="row-fluid marketing">';
          print '<div class="span12">' . $result_str . '</div>';
          foreach ($result['docs'] as $doc) {

            print '<div class="span12">';

            $description = implode("\n", $doc['description']);

            if (strlen($description) > 140) {
              $desc = substr($description, 0, 140) . '...';
            } else {
              $desc = $description;
            }

            if (is_array($doc['title'])) {
              $title = $doc['title'][0];
            } else {
              $title = $doc['title'];
            }

            print '<h4><a href="?action=lookup&itemID=' . $doc['_id'] . '">' . $title . '</a></h4>';
            print '<p>' . nl2br($desc) . '</p>';
            print '</div>';
          }
          print '</div>';
        } else if ($itemID) {
          $thing = $dpla->item_fetch(array($itemID));

          print '<div class="row-fluid marketing"><div class="span12">';

          Kint::dump($thing);

          print '</div></div>';
        }



      ?>




      <? } ?>


      <hr>

      <div class="footer">
        <p>Data from the Digital Public Library of America</p>
        <p>This prototype is using a quickly hacked together <a href="https://github.com/jblyberg/dpla/tree/master/20121109-appfest">DPLA PHP class</a></p>
      </div>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="bootstrap/js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap-transition.js"></script>
    <script src="bootstrap/js/bootstrap-alert.js"></script>
    <script src="bootstrap/js/bootstrap-modal.js"></script>
    <script src="bootstrap/js/bootstrap-dropdown.js"></script>
    <script src="bootstrap/js/bootstrap-scrollspy.js"></script>
    <script src="bootstrap/js/bootstrap-tab.js"></script>
    <script src="bootstrap/js/bootstrap-tooltip.js"></script>
    <script src="bootstrap/js/bootstrap-popover.js"></script>
    <script src="bootstrap/js/bootstrap-button.js"></script>
    <script src="bootstrap/js/bootstrap-collapse.js"></script>
    <script src="bootstrap/js/bootstrap-carousel.js"></script>
    <script src="bootstrap/js/bootstrap-typeahead.js"></script>

  </body>
</html>
