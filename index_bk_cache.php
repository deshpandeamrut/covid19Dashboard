<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- Basic Page Needs
         –––––––––––––––––––––––––––––––––––––––––––––––––– -->
      <meta charset="utf-8">
      <title>COVID-19 Dashboard | Bagalkot</title>
      <meta name="description" content="Bagalkot District COVID-19 Dashboard, corona stats, positive cases, positive COVID-19 cases list, quarantine list, list of grocery stores etc.">
      <meta name="Keywords" content="COVID-19,CORONA,BAGALKOT,DASHBOARD,QUARANTINE,ISOLATION,POSITIVE,CORONA TEST,COVID-19 TEST,COVID-19 CONFIRMED COUNT, GROCERY STORES BAGALKOT,MEDICAL HELP BAGALKOT,PATIENT LIST,GROCERY ONLINE DELIVERY BAGALKOT,KIRANA HOME DELIVERY BAGALKOT">
      <meta name="author" content="Amrut Deshpande">
	  <meta name="propeller" content="502566e05d7bca400eecfbfe1c8cb255">
      <!-- Mobile Specific Metas
         –––––––––––––––––––––––––––––––––––––––––––––––––– -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- FONT
         –––––––––––––––––––––––––––––––––––––––––––––––––– -->
      <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600&display=swap" rel="stylesheet" type="text/css">
      <link rel="manifest" href="manifest.webmanifest">
      <!-- CSS
         –––––––––––––––––––––––––––––––––––––––––––––––––– -->
      <link rel="stylesheet" href="https://covid19.nammabagalkot.in/css/normalize.css">
      <link rel="stylesheet" href="https://covid19.nammabagalkot.in/css/skeleton.css">
      <link rel="stylesheet" href="https://covid19.nammabagalkot.in/css/style.css?16">
	  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js""></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-colorschemes"></script>
   </head>
   <body>
      <!-- Primary Page Layout
         –––––––––––––––––––––––––––––––––––––––––––––––––– -->
      <?php
         include "functions.php";
         /* 
         Deprecated 
         include "samplexls.php";
         include "functions.php";
         date_default_timezone_set('Asia/Kolkata');
         $today = date("Ymd");   
         $todaysFileName = $today."gokfile.html";
         $todaysQFileName = $today."Qgokfile.xls";
         $todaysDataFile= $today."_data.csv";
         if(file_exists($todaysFileName)){
         }else{
          //file_put_contents($todaysFileName,file_get_contents("https://karunadu.karnataka.gov.in/hfw/kannada/Pages/covid19-db.aspx"));
          file_put_contents($todaysQFileName,file_get_contents("https://karunadu.karnataka.gov.in/hfw/kannada/homequarantivedocs/Bagalkote.xls"));
          write_todaysCountData($todaysFileName,$todaysDataFile);
         }
         $countData = getTodaysData($todaysDataFile);
         
         
         
         */ ?>
      <div class="container">
         <div>
            <a href="https://nammabagalkot.in" target="_new"><img  alt="nb_logo" style="display:block;margin:0px auto;"  src='nblogo.jpg'></a>
            <h5 style="text-align:center;">Covid-19 Dashboard | <span><a href="visualize.html">Visualize</a></span> | <span><a href="analysis.html">Analysis</a></span></h5>
         </div>
         <hr/>
         <p style="text-align:center">There are a total of 26 COVID testing labs in the state, Can our District representatives fight in setting up one in our district?<br/>Bagalkot District Corona Helpline No: 08354-236240, 08354-236240/1077 <br/>
            Last Updated: <span id="lastupdated">April 11th</span>
         </p>
         <hr/>
         <div class="row">
            <div class="two columns box" style="color:red">
               <h4 id="bgkCount">-</h4>
               <p>Covid19 Positive</p>
            </div>
            <div class="two columns box" style="color:#039c03">
               <h4 id="recoveredCount">-</h4>
               <p>Recovered</p>
            </div>
			 <div class="two columns box" style="">
               <h4 id="deathCount">1</h4>
               <p>Deaths</p>
            </div>
            <div class="two columns box" style="">
               <h4 id="awaitedCount">-</h4>
               <p>Test Results Awaited</p>
            </div>
            <div class="two columns box" style="">
               <h4 id="totalSamplesCount">-</h4>
               <p>Total Samples collected for test</p>
            </div>
            <div class="two columns box" style="">
               <h4 id="stateCount">-<span></span></h4>
               <p>Karnataka(total covid19 +ve)</p>
            </div>
         </div>
         <hr/>
         <script id="updates-template" type="text/x-handlebars-template">
            <h5 class="center">Updates</h5>
            <div class="updates-wrapper">
		<!--	<div class="update">
					<canvas id="UPDATE-GRAPH" width="250" height="300"></canvas>
					<p class="center"><a href="analysis.html">More Graphs</a></p>
            	</div> -->
            {{#each updates}}
            	<div class="update">
				<a href="{{this.img}}" target="_new"><img  src="{{this.img}}"></a>
            	<h6 class="update-title">{{this.title}}</h6>
            	<p class="date">{{this.date}}</p>
            	<p class="update-description">{{{this.description}}}</p>
            	
            	</div>
            {{/each}}
            </div>
         </script>
         <div  class="updates" id="updates">
         </div>
         <script id="patient-template" type="text/x-handlebars-template">
            <h5 class="center">Covid-19 Patient List | <span><a href="visualize.html"> Visualize</a></span></h5>
            	<div id="patient-table" class="table-wrapper">
            	<table>
            	<tr><td>Patient Id</td><td>Published Date</td><td>Age</td><td>Gender</td><td>Status</td><td>Source</td><td>Residence</td><td>Comments</td></tr>
            	{{#each patients}}
            		<tr><td>{{this.pid}}</td><td>{{this.date}}</td><td>{{this.age}}</td><td>{{this.gender}}</td><td>{{this.status}}</td><td><a href="{{this.source}}">link</a></td><td>{{this.place}}</td><td>{{this.comments}}</td></tr>
            		</div>
            	{{/each}}
            	</table>
            	</div>
         </script>
         <div  class="patients" id="patients">
         </div>
         <h5 class="center">Essentials</h5>
         <div class="gstores">
            <?php 
               $gStores = getGroceryStores();	
               foreach ($gStores as $value) {
               	echo "<div class='gstore'><h6>".$value['name']."</h6><p>".$value['description']."<br/>".$value['address']."<br/>Mob:".$value['mobile']."<br/>".$value['comments']."</p></div>";
               }
               echo "<div class='gstore vh-center'><h3><a class='button' href='https://www.facebook.com/bagalkotcity/posts/1515082128630498' target='_new'>Add your Store</a></h3></div>";
               echo "<div class='gstore vh-center'><p>None of the shops are open & none of them are delivering? <a class='button' href='https://www.facebook.com/bagalkotcity/posts/1515082128630498' target='_new'>Message us</a></p></div>";
               ?>
         </div>
         
         <p style="text-align:center" class="credits">Note: This data is intended to create awareness among people and to help right people to take decisons.</p>
         <p style="text-align:center" class="credits">With curiosity by <a href="https://facebook.com/deshpandeamrut" target="_new">Amrut Deshpande</a> | Data extracted from <a href="https://karunadu.karnataka.gov.in/hfw/kannada/pages/home.aspx">GOK Website</a> and https://api.covid19india.org</p>
      </div>
    
		 <script src="js/jquery.min.js"></script>
      <!-- Adsesnse 
 	  <script data-ad-client="ca-pub-7389348172038480" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	  -->
      <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
      <script>
         var OneSignal = window.OneSignal || [];
         OneSignal.push(function() {
           OneSignal.init({
             appId: "0f06be46-3b02-446e-83f2-bacc93ddcddf",
           });
         });
      </script>
	
      <!-- Include Handlebars from a CDN -->
      <script src="https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.js"></script>
      <script>
         
        
        var updatesUrl  ="getJson.php?f=data/updates";
        var statsDataUrl  ="https://covid19.nammabagalkot.in/getJson.php?f=data/statsData";
        var statesDataCovidApi  ="https://api.covid19india.org/data.json";
		var graphDataUrl  ="https://covid19.nammabagalkot.in/getJson.php?f=graph";
		
		var d = new Date();
		d.setMinutes(d.getMinutes() - 5);                 
		var storageDate = localStorage.getItem("storedAtIndex");
		var sDate = new Date(storageDate);
		if(sDate  !== null && d.getTime()<sDate.getTime()){//if not expired
			//drawGraph(JSON.parse(localStorage.getItem("graphData")));
			updateCounts(JSON.parse(localStorage.getItem("statsData")));
			fetchUpdates(JSON.parse(localStorage.getItem("updatesData")));
			updateWithCovidAPi(JSON.parse(localStorage.getItem("covidApiData")));
			printPatients(JSON.parse(localStorage.getItem("graphData")));
		}else{//if not set or expired
			console.log("Fetched from api, calling function now.");
			$.get(statsDataUrl,function(data){
				updateCounts(data);
				localStorage.setItem("statsData",JSON.stringify(data));
			});	
			$.get(updatesUrl,function(updatesData){
				fetchUpdates(updatesData);
				localStorage.setItem("updatesData",JSON.stringify(updatesData));
				$.get(statesDataCovidApi,function(data){
					updateWithCovidAPi(data);
					localStorage.setItem("covidApiData",JSON.stringify(data));
				});
			});
			
			$.get(graphDataUrl,function(graphData){
				//drawGraph(graphData);
				printPatients(graphData)
				localStorage.setItem("graphData",JSON.stringify(graphData));
			});
			
			localStorage.setItem("storedAtIndex",new Date());
		}
		
         var bgkCount = 0;
         var stateCount = 214;
         
        
		function fetchUpdates(data){
			var source = document.getElementById("updates-template").innerHTML;
         	var template = Handlebars.compile(source);
         	var context = {updates:data.updates.reverse()};
         	var html = template(context);
         	$("#updates").html(html);
		}
         
          
        
		function updateCounts(data){			
         	$("#lastupdated").html(data.lastupdated);
         	bgkCount = data.stats.positive;
         	stateCount = data.stats.stateCount;
         	$("#bgkCount").html(data.stats.positive);
			$("#totalSamplesCount").html(data.stats.totalTests);
         	$("#stateCount").html(data.stats.stateCount);
         	$("#positiveCount").html(data.stats.positive);
         	$("#deathCount").html(data.stats.death);
         	$("#awaitedCount").html(data.stats.awaited)
		}
         
		function updateWithCovidAPi(data){
			$.each(data.statewise, function(i, item) {
         		if(item.state=='Karnataka'){
         			if(stateCount<parseInt(item.confirmed)){
         						stateCount = parseInt(item.confirmed);
         					}
         			$("#stateCount").html(stateCount);
         		}
         	});	
		}
         
		
	function printPatients(data){ 
		console.log(data);
		var source = document.getElementById("patient-template").innerHTML;
		var template = Handlebars.compile(source);
		if(bgkCount<data.nodes.length){
			bgkCount = data.nodes.length;
		}
		$("#bgkCount").html(bgkCount);

		/** Recovered Count Calculation */
		const statusArray = data.nodes;
		var statusProperty = "status";
		const countByStatus = _.groupBy(statusArray, statusProperty);
		$("#recoveredCount").html(countByStatus['Recovered'].length);
		/* End */

		data.nodes.reverse();
		var context = {patients:data.nodes};
		var html = template(context);
		$("#patients").html(html);
	}
    function drawGraph(graphData){
		
		/* TALUKA WISE GRAPH */	
         	const talukaArray = graphData.nodes;
         	talukaProperty = "place";
         	const countByTaluka = _.groupBy(talukaArray, talukaProperty);
         	var taluka = {};
         	var talukaCount = [];
         	var talukaColors = ["#7e3bec", "#6f3875", "#e13af2", "#ef9d15", "#09d93c", "#e13af2", "#f7befb", "#cef1d7", "#09780a"];
         	$.each(countByTaluka, function(key,value) {
				if(key.toLowerCase().includes("jam")){
					key  = "Jamkhandi";
				}
				if(key.toLowerCase().includes("bag")){
					key  = "Bagalkot";
				}
				if(key.toLowerCase().includes("mud")){
					key  = "Mudhol";
				}
				if(key in taluka){
					taluka[key] = taluka [key] + value.length;
				}else{
					taluka[key] = value.length;
				}
         	}); 
           		var ctx = document.getElementById('UPDATE-GRAPH').getContext('2d');
         		//var ctx = canvas.getContext('2d');
         		var config = {
         		   type: 'pie',
         		   data: {
         			  labels: Object.keys(taluka),
         			  datasets: [{
         				 data: Object.values(taluka),
         				 //backgroundColor: talukaColors,
         			  }]
         		   },
				    options: {
						plugins: {
							colorschemes: {
										scheme: 'brewer.SetTwo5'
										}
								}
						}
         		};
         
         		var chart = new Chart(ctx, config);
         	/* END TALUKA WISE GRAPH*/
		
	}
	 $("#toggle-q-list").click(function(){
			$("#q-table-wrapper").toggle();
	 });
         
         
      </script>
     
	 <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-24636577-6"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-24636577-6');
</script>

	  
	  
      <script>
	  /* Table search*/
         var $rows = $('#table tr').not(":first");
         $('#search').keyup(function() {
             var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
             
             $rows.show().filter(function() {
                 var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                 return !~text.indexOf(val);
             }).hide();
         });
		 
		 
      </script>
	   <script>
         
         
         
      </script>
	 <!-- <script type="text/javascript" src="//ofgogoatan.com/apu.php?zoneid=3234318" async data-cfasync="false"></script> -->
   </body>
</html>