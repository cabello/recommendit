<?php session_start();
require ('bd.php');
require ('util.php');

if ( ! $_SESSION['user_id']) {
  header('Location: index.php');
}
?>

<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">

  <!-- Use the .htaccess and remove these lines to avoid edge case issues.
       More info: h5bp.com/i/378 -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title></title>
  <meta name="description" content="">
  <!-- Mobile viewport optimized: h5bp.com/viewport -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
  <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->
  <link rel="stylesheet" href="css/bootstrap.css">
  <!-- More ideas for your head here: h5bp.com/d/head-Tips -->

  <!-- For the sticky footer -->
	<!--[if !IE 7]><style type="text/css">#sf-wrapper {display:table;height:100%}</style><![endif]-->

  <!-- All JavaScript at the bottom, except this Modernizr build.
       Modernizr enables HTML5 elements & feature detects for optimal performance.
       Create your own custom Modernizr build: www.modernizr.com/download/ -->
  <script src="extras/h5bp/js/libs/modernizr-2.5.3.min.js"></script>
  <style type="text/css">
  #rateStatus{float:left; margin-left: 4px;}
  #rateMe{float:left; margin-left: 4px; height:auto;}
  #rateMe li{float:left;list-style:none;}
  #rateMe li a:hover,
  #rateMe a{float:left;}
  #ratingSaved{display:none;}
  .saved{color:red; }


  #rateStatus2{float:left; margin-left: 4px;}
  #rateMe2{float:left; margin-left: 4px; height:auto;}
  #rateMe2 li{float:left;list-style:none;}
  #rateMe2 li a:hover,
  #rateMe2 a{float:left;}
  #ratingSaved2{display:none;}

  </style>
</head>
<body>
  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7]>
    <link href="css/bootstrap.ie6.css" rel="stylesheet">
  	<p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p>
  <![endif]-->
<div id="sf-wrapper">
	<div class="container main">
  	<header>

  	</header>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="brand" href="#">recommendIt</a>
        </div>
      </div>
    </div>

    <div role="main">
        <div class="row-fluid">
            <div class="span12">
                  <?php

$pictures = array();

$query = "https://graph.facebook.com/me?fields=picture&access_token=".$_SESSION["token"];
$my_picture = json_decode(file_get_contents($query));
$pictures[$_SESSION['user_id']] = $my_picture->picture;

$query = "https://graph.facebook.com/".$_SESSION['user_id']."/friends?fields=id,picture&access_token=".$_SESSION["token"];
$response = file_get_contents($query);
$data = json_decode($response, true);

// user stuff
$friends_ids = '(';
foreach ($data["data"] as $item) {
  $friends_ids .= $item["id"] . ',';
  $pictures[$item["id"]] = $item["picture"];
};
$friends_ids .= $_SESSION['user_id'].')';

$q2 = "SELECT service.name service_name, service.id service_id, worker.*, recommendation.* FROM service INNER JOIN worker ON service.id = worker.id_service INNER JOIN recommendation ON worker.id = recommendation.id_worker WHERE recommendation.id_facebook IN {$friends_ids} ORDER BY service.name, service.id, worker.name, worker.id";
$works2 = mysql_query($q2);
if (! $works2) {
  echo "<pre>";
  echo mysql_error();
  echo "</pre>";
}

$avgs = array();
$avgs_query = "SELECT id_worker, avg(rating) avg_rating FROM recommendation WHERE id_facebook IN {$friends_ids} GROUP BY id_worker";
$avgs_result = mysql_query($avgs_query);
if (! $avgs_result) {
  echo "<pre>";
  echo mysql_error();
  echo "</pre>";
}
while ($record = mysql_fetch_assoc($avgs_result)) {
  $avgs[$record['id_worker']] = $record['avg_rating'];
}

$mask = "(##) ####-####";

$open_span7 = false;
$service = null;
$worker = null;
while ($rec = mysql_fetch_assoc($works2)) {
  if ($service == null || $service != $rec['service_name']) {
    if ($open_span7) {
      echo '    </div>';
      echo '</div>';
      $open_span7 = false;
    }

    $service = $rec['service_name'];
    echo '<h2 class="service-name">'.$rec["service_name"].' <a class="icon-plus-sign" data-toggle="modal" href="#modal-new-worker" data-id-service="'.$rec['service_id'].'" data-service-name="'.$rec["service_name"].'"></a></h2>';
  }

  if ($worker == null || $worker != $rec['name']) {
    if ($open_span7) {
      echo '    </div>';
      echo '</div>';

      $open_span7 = false;
    }

    $worker = $rec['name'];

    echo '<div class="row-fluid row-recommendation">';
    $rating = $avgs[$rec['id_worker']];
    echo '    <div class="span5">'.$rec["name"].' - '.phone_mask($mask,$rec["phone"]).' <a class="rate_old_worker" data-toggle="modal" data-worker-name="'.$rec["name"].'" data-worker-id="'.$rec["id_worker"].'" data-service-name="'.$rec["service_name"].'" data-id-service="'.$rec['service_id'].'" href="#oldWorker">';
    for ($i = 1; $i <= 5; $i++) {
      if ($i <= $rating) {
        echo '<span class="icon-star"></span>&nbsp';
      } else {
        echo '<span class="icon-star-empty"></span>&nbsp';
      }
    }
    echo '</a></div>';
    echo '    <div class="span7">';
    $open_span7 = true;
  }

  echo '<a href="#" class="rating-comment" rel="tooltip" title="&nbsp;'.$rec["comment"].' '.stars($rec["rating"]).'"><img src="'.$pictures[$rec["id_facebook"]].'" /></a>';
}

if ($worker != null) {
  echo '    </div>';
  echo '</div>';
}

function stars($rating) {
  $return = '';

  for ($i = 0; $i < $rating; $i++) {
    $return .= "<span class='icon-star'></span>&nbsp";
  }

  return $return;
}
?>

            </div><!--/span-->
      </div><!--/row-fluid-->

      <div class="modal fade" id="modal-new-worker">
        <div class="modal-header">
          <a class="close" data-dismiss="modal">×</a>
          <h3 id="new-worker-service-name"></h3>
        </div>
        <div class="modal-body">
          <form class="form-inline" id='new-worker-form'>
            <input type="text" class="input-large name" placeholder="Name" name="name" id="new-worker-name" />
            <input type="text" class="input-small" placeholder="Phone" name="phone" id="new-worker-phone" />
              <div id="rateMe" title="Rate Me..." class="rating rateMe">
                <input type="hidden" name="rating" id="rating" />
                <a title="ehh..." class="icon-star-empty" data-rating="1"></a>
                <a title="Not Bad" class="icon-star-empty" data-rating="2"></a>
                <a title="Pretty Good" class="icon-star-empty" data-rating="3"></a>
                <a title="Outstanding" class="icon-star-empty" data-rating="4"></a>
                <a title="Freakin' Awesome!" class="icon-star-empty" data-rating="5"></a>
                <span id="rateStatus" class="rateStatus"></span>
                <span id="ratingSaved" class="rateSaved"></span>
              </div>

            <input type="hidden" name="id_service" id="new-worker-id_service" value="1" />
            <textarea class="input-xlarge comment" placeholder="Comment" rows="3" name="comment" id="new-worker-comment"></textarea>
          </form>
        </div>
        <div class="modal-footer">
          <a href="#" class="btn btn-primary" data-dismiss="modal" id="add-new-worker">Recommend</a>
        </div>
      </div>


		      <div id='fb-root'></div>
		      <script src='http://connect.facebook.net/en_US/all.js'></script>

		      <script>

		      FB.init({appId: <?php echo $_SESSION["app_id"];?>, status: true, cookie: true});

		      function postToFeed() {
			      // calling the API ...
			      var obj = {
    					method: 'feed',
    					link: 'http://recommendit.herokuapp.com/',
    					picture: 'http://fbrell.com/f8.jpg',
    					name: 'Facebook - RecommendIt',
    					caption: '',
					message: 'Check out my new recommendation on RecommendIt!',
    					description: 'Share your recommendations, help your friends!'
			      };

			      function callback(response) {
				      document.getElementById('msg').innerHTML = "Post ID: " + response['post_id'];
			      }
			      FB.ui(obj, callback);
            window.scrollTo(0);
		      }

</script>



      <div class="modal fade" id="oldWorker">
        <div class="modal-header">
          <a class="close" data-dismiss="modal">×</a>
          <h3 id="old_service_name"></h3>
        </div>
        <div class="modal-body">
          <form class="new-comment-form">
            <p class="rating">
              <span id="old_worker_message"></span>
              <div id="rateMe2" title="Rate Me..." class="rating rateMe">
                <input type="hidden" name="rating" id="rating2" />
                <a title="ehh..." class="icon-star-empty" data-rating="1"></a>
                <a title="Not Bad" class="icon-star-empty" data-rating="2"></a>
                <a title="Pretty Good" class="icon-star-empty" data-rating="3"></a>
                <a title="Outstanding" class="icon-star-empty" data-rating="4"></a>
                <a title="Freakin' Awesome!" class="icon-star-empty" data-rating="5"></a>
                <span id="rateStatus2" class="rateStatus"></span>
                <span id="ratingSaved2" class="rateSaved"></span>
              </div>
            </p>
            <textarea class="input-xlarge comment" placeholder="Comment" rows="3" name="comment" id="new-comment-comment"></textarea>
            <input type="hidden" id="old_worker_id" name="id_worker" />
            <input type="hidden" id="old_service_id" name="id_service" />
          </form>
        </div>
        <div class="modal-footer">
          <a href="#" class="btn btn-primary" data-dismiss="modal" id="add-new-comment">Add comment</a>
        </div>
      </div>

      <hr>

        <div class="container">
            <footer style="text-align: center">
                <p><i class="icon-github-sign"></i> crafted in 24 hours during facebook@brazil hackathon 2012</p>
            </footer>
        </div>
    </div>

	  <!-- JavaScript at the bottom for fast page loading -->

	  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
	  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	  <script>window.jQuery || document.write('<script src="extras/h5bp/js/libs/jquery-1.7.1.min.js"><\/script>')</script>
	  <!-- scripts concatenated and minified via ant build script-->
	  <script src="extras/prettify/prettify.js"></script>
	  <script src="js/bootstrap.min.js"></script>

	  <!-- end scripts-->

	  <!-- If you'd rather pick and choose, comment the above and uncomment what you need below -->
	  <!--script type="text/javascript" src="js/bootstrap-alert.min.js"></script-->
	  <!--script type="text/javascript" src="js/bootstrap-button.min.js"></script-->
	  <!--script type="text/javascript" src="js/bootstrap-carousel.min.js"></script-->
	  <!--script type="text/javascript" src="js/bootstrap-collapse.min.js"></script-->
	  <!--script type="text/javascript" src="js/bootstrap-dropdown.min.js"></script-->
	  <!--script type="text/javascript" src="js/bootstrap-modal.min.js"></script-->
	  <!--script type="text/javascript" src="js/bootstrap-modal.min.js"></script-->
	  <!--script type="text/javascript" src="js/bootstrap-modal.min.js"></script-->
	  <!--script type="text/javascript" src="js/bootstrap-popover.min.js"></script-->
	  <!--script type="text/javascript" src="js/bootstrap-scrollspy.min.js"></script-->
	  <!--script type="text/javascript" src="js/bootstrap-tab.min.js"></script-->
	  <!--<script type="text/javascript" src="js/bootstrap-tooltip.min.js"></script>-->
	  <!--script type="text/javascript" src="js/bootstrap-transition.min.js"></script-->
	  <!--script type="text/javascript" src="js/bootstrap-typeahead.min.js"></script-->
	  <!--script type="text/javascript" src=""></script-->
    <script type="text/javascript" language="javascript" src="js/ratingsys.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
    <script type="text/javascript" src="extras/jgrowl/jquery.jgrowl.min.js" ></script>

	  <!-- end scripts -->

	  <!-- Asynchronous Google Analytics snippet. Change UA-XXXXX-X to be your site's ID.
	       mathiasbynens.be/notes/async-analytics-snippet -->

	  <script type="text/javascript">
	  // Use the modernizr.load() function to run polyfills for older browsers.
	    Modernizr.load({

	    });
	  </script>
    <script type="text/javascript">
      $(document).ready(function() {
        $('.rating-comment').tooltip();
        $('.rating a').hover(rating, off);
        $('.rating a').click(rateIt);
        $('#add-new-worker').click(function() {
          $.post('new_worker.php', $('#new-worker-form').serialize(), function() {
            $.jGrowl("Recommendation added!");
            postToFeed();
          });
          $('#modal-new-worker').modal('hide');
          $('#new-worker-name').val('');
          $('#new-worker-phone').val('');
          $('#new-worker-comment').val('');
          rated = 0;
        });

        $('.rating2 a').hover(rating, off);
        $('.rating2 a').click(rateIt);
        $('#add-new-comment').click(function() {
          $.post('new_comment.php', $('.new-comment-form').serialize(), function(){
            $.jGrowl("Commentation added!")
          });
          $('#oldWorker').modal('hide');
          $('#new-comment-comment').val('');
          resetRate();
        });

        $('.service-name a').click(function(e) {
          $('#new-worker-id_service').val($(e.target).data('id-service'));
          $('#new-worker-service-name').html($(e.target).data('service-name'));
        });
        $('.rate_old_worker').click(function(e){
          console.log(e);
          $('#old_worker_id').val($(e.target.parentNode).data('worker-id'));
          $('#old_worker_message').html($(e.target.parentNode).data('worker-name'));
          $('#old_service_name').html($(e.target.parentNode).data('service-name'));
          $('#old_service_id').val($(e.target.parentNode).data('id-service'));
        });
      });
      </script>
	  <script>
	    var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
	    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
	    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
	    s.parentNode.insertBefore(g,s)}(document,'script'));
	  </script>
  </div><!-- End .container.main -->
</div><!-- End #sf-wrapper -->
  <!-- A little ie7- magic -->
  <script type="text/javascript"> $(function(){if($.browser.msie&&parseInt($.browser.version,10)===6){$('.row div[class^="span"]:last-child').addClass("last-child");$('[class="span"]').addClass("margin-left-20");$(':button[class="btn"], :reset[class="btn"], :submit[class="btn"], input[type="button"]').addClass("button-reset");$(":checkbox").addClass("input-checkbox");$('[class^="icon-"], [class=" icon-"]').addClass("icon-sprite");$(".pagination li:first-child a").addClass("pagination-first-child")}}) </script>
</body>
</html>
