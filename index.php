<?php
ob_start();
?>
<html>
	<head>
		<title>Student Schedule Creator</title>
		<link href="http://kp4assets.richmond.edu/images/kp4/static/favicon.ico" rel="shortcut icon"/>
		<link href="http://d2r44v0ubjhg6i.cloudfront.net/images/kp4/apple-touch-icon.png" rel="apple-touch-icon" />
        <link href="http://d2r44v0ubjhg6i.cloudfront.net/images/kp4/apple-touch-icon-76x76.png" rel="apple-touch-icon" sizes="76x76" />
        <link href="http://d2r44v0ubjhg6i.cloudfront.net/images/kp4/apple-touch-icon-120x120.png" rel="apple-touch-icon" sizes="120x120" />
        <link href="http://d2r44v0ubjhg6i.cloudfront.net/images/kp4/apple-touch-icon-152x152.png" rel="apple-touch-icon" sizes="152x152" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css"></link>
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script src="//cdn.jsdelivr.net/jquery.scrollto/2.1.2/jquery.scrollTo.min.js"></script>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		  ga('create', 'UA-69105822-1', 'auto');
		  ga('send', 'pageview');
		</script>
		<style>
			.navbar-brand-name > img {
				max-height:70px;
				width:auto;
				padding: 0 15px 0 0;
			}
			
			.navbar {
				min-height: 90px;
				background-color: #4788c6;
			}
			
			.navbar-brand{
				min-height: 90px;
				height:auto;
				max-height: 120px;
			}
		</style>
		<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
	</head>
	<body>
		<nav class="navbar navbar-default navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" style="padding: 10 15px;" href="#">
						<div class="navbar-brand-name">
							<img src="http://www.richmond.edu/_KP4_assets/images/kp4/shield.png"/>
							<span style="color:#ffffff">University of Richmond Scheduler</span>
						</div>
					</a>
				</div>
			</div>
		</nav>
		<div class="container-fluid">
			<div class="col-md-12">
				<div class="jumbotron">
					<h1>Welcome to the University of Richmond Scheduler!</h1>
					<p>Use the search below to find courses and then click the&nbsp;<button class="glyphicon glyphicon-plus btn btn-success" style="line-height:1em!important"></button>&nbsp;to add the course to your basket.</p>
					<p>Then click "Create Schedule" to generate every possible schedule</p>
					<p><a class="btn btn-primary btn-success btn-lg btn-jumbo-close" role="button">Okay!</a></p>
				</div>
				<div class="page-header" style="margin-top:0px;">
					<h2>Make a Schedule</h2>
				</div>
			</div>
			<div class="col-md-8">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h1 class="panel-title">Search for Courses</h1>
					</div>
					<div class="panel-body">
						<h5>If searching by course title fails, try field of study and course number, ex CMSC 315</h5>
						<input id="searchField" class="form-control search" name="fields[]" type="text" placeholder="Search by name or subject area and course number"></input>
						<hr width="100%"/>
						<div id="search-results">
						</div>
					</div>
				</div>
			</div>
			<div class= "col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h1 class="panel-title">Selected Courses</h1>
					</div>
					<div class="panel-body">
						<ul class="list-group" id="course-basket">
						<?php
							ob_flush();
							flush();
							$get = false;
							if(isset($_GET["i"])){
								$get = $_GET["i"];
								$get = json_decode($get, true);
							}
							
							function jsonp_decode($jsonp, $assoc = false) { // PHP 5.3 adds depth as third parameter to json_decode
								if($jsonp[0] !== '[' && $jsonp[0] !== '{') { // we have JSONP
								   $jsonp = substr($jsonp, strpos($jsonp, '('));
								}
								return json_decode(trim($jsonp,'();'), $assoc);
							}
							
							if($get != false){
								foreach($get as $k=>$v){
									echo '<li class="list-group-item" data-fos="'.$v["FOS"].'" data-coursenum="'.$v["CourseNum"].'" data-coursename="'.$v["Title"].'">';
									echo $v["FOS"]." ".$v["CourseNum"]." | ".$v["Title"].'<button class="btn btn-danger glyphicon glyphicon-minus btn-remove-course pull-right" type="button" style="line-height: 1!important;" id="basket-remove" data-coursenum="'.$v["CourseNum"].'" data-fos="'.$v["FOS"].'" data-coursename="'.$v["Title"].'"></button></li>';
									ob_flush();
									flush();
								}
							}
						?>
						</ul>
						<button type="submit" class="btn btn-success btn-generate">Create Schedule</button>
					</div>
				</div>
			</div>
		</div>
	</body>
	
	<div class="hide panel panel-default" id="searchResultTemplate">
		<div class="panel-heading">
			<h1 class="panel-title pull-left" id="title"></h1>
			<button class="btn btn-success glyphicon glyphicon-plus pull-right btn-add-course" type="button" style="line-height: 1!important;" id="button" data-search="true"></button>
			<div class="clearfix"></div>
		</div>
		<div class="panel-body">
		</div>
	</div>
	
	<li class="hide list-group-item" id="addedTemplate"></li>
	<button class="hide btn btn-danger glyphicon glyphicon-minus btn-remove-course pull-right" type="button" style="line-height: 1!important;" id="basket-remove"></button>
	
	<script>
		var $defaultSearchResult = $("#searchResultTemplate");
		var $addedTemplate = $("#addedTemplate");
		var $buttonRemoveTemplate = $("#basket-remove");
		
		$("#searchField").autocomplete({source:function(request, response){var loc = request.term; $.getJSON('/sched/richmond/richmondAPI.php?search='+loc+'&callback=?', function(courseData){
		courseData = eval(courseData.response);
		$("#search-results").empty();
		$.each(courseData, function(i,v){
			var $newPanel = $defaultSearchResult.clone();
			
			 $.getJSON('http://assets.richmond.edu/catalogs/courses.php?orderby=subjnum&archiveYear=2015&term=&catalogtype=ug&paginate=false&subj='+v["FOS"]+'&level='+v["Course Number"].substr(0, 1)+'00&keyword=&callback=?', function(data){
				 data = data.courses;
				 
				 var initial = data.substring(data.indexOf("</span>"+v["FOS"]+" "+v["Course Number"]));
				 var end = initial.substring(0, initial.indexOf('<!--close inner-content-wrap'));
				 var title = end.substring(v["FOS"].length+9+v["Course Number"].length, end.indexOf("</a>"));
				 var descr = end.substring(end.indexOf("Description</div>")+17);
				 descr = descr.substring(0, descr.indexOf("</div>"));
				 var units = end.substring(end.indexOf("Units: ")+7, end.indexOf("</div>"));
				 
				 if(end.indexOf("Prerequisites</div>")>-1){
					 var prereq = end.substring(end.indexOf("Prerequisites</div>")+19);
					 prereq = prereq.substring(0, prereq.indexOf("</div>"));
				 }
				 
				 if(v["FOS"] != "FYS"){
					v["Title"] = title;
				 }
				 
				 var html = "<h4>"+title+"</h4><p>"+descr+"</p><p>Units: "+units+"</p>";
				 if(prereq != undefined){
					 html = html+"<p>Prerequisites: "+prereq+"</p>";
				 }
				 
				$newPanel.find("#title").text(v["FOS"]+" "+v["Course Number"]+" | "+v["Title"]);
				$newPanel.find(".panel-body").html(html);
				$newPanel.find("#button").attr("data-fos", v["FOS"]);
				$newPanel.find("#button").attr("data-coursenum", v["Course Number"]);
				$newPanel.find("#button").attr("data-coursename", v["Title"]);
				
				if(v["Available"] == "false"){
					$newPanel.find("#button").removeClass("btn-success");
					$newPanel.find("#button").removeClass("btn-add-course");
					$newPanel.find("#button").removeClass("glyphicon-plus");
					$newPanel.find("#button").addClass("btn-disable");
					$newPanel.find("#button").text("Course Not Available");
				}
				
				$newPanel.removeClass("hide");
				$newPanel.attr("id", "");
				
				var $list = $("#course-basket").find("li");
				$list.each(function(){
					if($(this).data("fos") == v["FOS"] && $(this).data("coursenum") == v["Course Number"] && $(this).data("coursename") == v["Title"]){
						$newPanel.find("#button").removeClass("glyphicon-plus");
						$newPanel.find("#button").removeClass("btn-success");
						$newPanel.find("#button").removeClass("btn-add-course");
						$newPanel.find("#button").addClass("btn-danger");
						$newPanel.find("#button").addClass("glyphicon-minus");
						$newPanel.find("#button").addClass("btn-remove-course");
					}
				});
				
				$("#search-results").append($newPanel);
			 });
		});
		//response(data2);
		});},
		select: function(event, ui){
			var index = event.target.id;
			}
		});
		
		$(document).on("click", ".btn-generate", function (e) {
			var $courses = $("#course-basket li");
			var getCourses = new Array();
			var count = 0;
			$courses.each(function(){
				var temp = {CourseNum:$(this).data("coursenum"), FOS:$(this).data("fos"), Title:$(this).data("coursename")};
				getCourses.push(temp);
				count++;
			});
			var json = JSON.stringify(getCourses);
			if(count>5){
				window.alert("Trying to generate schedules with this many courses may take a long time, but I will try.  \n\nThe page will appear to be loading until it is finished, so do not refresh the page.  \n\nThe calculation is allowed take up to 5 minutes, if it takes longer, it will fail.");
			}
			window.location.assign("/sched/richmond/makeSchedule.php?i="+encodeURIComponent(json));
		});
		
		$(document).on("click", ".btn-jumbo-close", function(){
			$(this).parent().parent().hide();
		});
		
		$(document).on("click", ".btn-remove-course", function (e) {
			var $course = $(e.target);
			
			var fos = $course.data("fos");
			var num = $course.data("coursenum");
			var name = $course.data("coursename");
			
			if($course.data("search")){
				$course.addClass("glyphicon-plus");
				$course.addClass("btn-success");
				$course.addClass("btn-add-course");
				$course.removeClass("btn-danger");
				$course.removeClass("glyphicon-minus");
				$course.removeClass("btn-remove-course");
			}
			else{
				var $list = $("#search-results button");
				$list.each(function(){
					if($(this).data("fos") == fos && $(this).data("coursenum") == num && $(this).data("coursename") == name){
						$(this).addClass("glyphicon-plus");
						$(this).addClass("btn-success");
						$(this).addClass("btn-add-course");
						$(this).removeClass("btn-danger");
						$(this).removeClass("glyphicon-minus");
						$(this).removeClass("btn-remove-course");
					}
				});
			}
			var $list = $("#course-basket").find("li");
			$list.each(function(){
				if($(this).data("fos") == fos && $(this).data("coursenum") == num && $(this).data("coursename") == name){
					$(this).remove();
				}
			});
		});
		
		$(document).on("click", ".btn-add-course", function (e) {
			var $course = $(e.target);
			$course.removeClass("glyphicon-plus");
			$course.removeClass("btn-success");
			$course.removeClass("btn-add-course");
			$course.addClass("btn-danger");
			$course.addClass("glyphicon-minus");
			$course.addClass("btn-remove-course");
			
			var fos = $course.data("fos");
			var num = $course.data("coursenum");
			var name = $course.data("coursename");
			
			var $add = $addedTemplate.clone();
			var $button = $buttonRemoveTemplate.clone().removeClass("hide")
			
			$button.attr("data-fos", fos);
			$button.attr("data-coursenum", num);
			$button.attr("data-coursename", name);
			$add.removeClass("hide");
			$add.attr("id", "");
			$add.text(fos+" "+num+" | "+name);
			$add.append("&nbsp; &nbsp; &nbsp; &nbsp;", $button);
			$add.attr("data-fos", fos);
			$add.attr("data-coursenum", num);
			$add.attr("data-coursename", name);
			
			$("#course-basket").append($add);
		});
	</script>
</html>
<?php
	ob_flush();
	flush();
	ob_end_clean();
?>