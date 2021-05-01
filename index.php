<!DOCTYPE html>
<html lang="en">
<head>
      <!-- Basic Page Needs
       –––––––––––––––––––––––––––––––––––––––––––––––––– -->
       <meta charset="utf-8">
       <title>Bagalkot COVID-19 Dashboard | NammaBagalkot</title>
       <meta name="description" content="Bagalkot District COVID-19 Dashboard, corona stats, positive cases, positive COVID-19 cases list, quarantine list, list of grocery stores etc.">
       <meta name="keywords" content="COVID-19,CORONA,BAGALKOT,DASHBOARD,QUARANTINE,ISOLATION,POSITIVE,CORONA TEST,COVID-19 TEST,COVID-19 CONFIRMED COUNT,ESSENTIAL STORES BAGALKOT,MEDICAL HELP BAGALKOT,PATIENT LIST,GROCERY ONLINE DELIVERY BAGALKOT,KIRANA HOME DELIVERY BAGALKOT,Badami,Jamkhandi,Mudhol,active covid19 patients,recivered patients">
       <meta name="author" content="Amrut Deshpande">
       <meta name="propeller" content="502566e05d7bca400eecfbfe1c8cb255"> 

      <!-- Mobile Specific Metas
       –––––––––––––––––––––––––––––––––––––––––––––––––– -->
       <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- FONT
       –––––––––––––––––––––––––––––––––––––––––––––––––– -->
       <!--  <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600&display=swap" rel="stylesheet" type="text/css"> -->
      <!-- MANIFEST
       –––––––––––––––––––––––––––––––––––––––––––––––––– -->
       <link rel="manifest" href="manifest.webmanifest">
      <!-- CSS
       –––––––––––––––––––––––––––––––––––––––––––––––––– -->
       <link rel="stylesheet" href="https://covid19.nammabagalkot.in/css/normalize.css">
       <link rel="stylesheet" href="https://covid19.nammabagalkot.in/css/skeleton.css">
       <link rel="stylesheet" href="css/style.css?0805">

      <!-- JS
       –––––––––––––––––––––––––––––––––––––––––––––––––– -->
       <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js""></script>
       <script type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.min.js"></script>
       <script type="text/javascript"  src="https://cdn.jsdelivr.net/npm/chartjs-plugin-colorschemes"></script>
     </head>
     <body>
      <!-- Primary Page Layout
       –––––––––––––––––––––––––––––––––––––––––––––––––– -->
       <?php //include "functions.php"; ?>

       <div class="container">
        <div>
         <a href="https://nammabagalkot.in" target="_new"><img  alt="nb_logo" style="display:block;margin:0px auto;"  src='nblogo.jpg'></a>
         <h1 style="text-align:center;margin-top: 1rem;font-size: 1.9rem;">Covid-19 Dashboard</h1>
       </div>
       <hr/>
       <div id="stats-container">
       </div>
       <script id="stats-template" type="text/x-handlebars-template">
        <p class="center">{{stats.stats.date}}</p>
        <div class="row stats-wrapper">

         <div class="box" style="color:red">
          <p style="margin-bottom:0px;">
            <span class="stats-number" id="bgkCount">
              {{stats.stats.confirmed}}
            </span>
            <span class="stats-increment" id="bgkCount-rise">
            </span></p>
            <p>Confirmed</p>
          </div>
          <div class="box" style="color:green">
            <p class="stats-number" id="activeCount">{{stats.stats.recovered}}</p>
            <p>Recovered</p>
          </div>
          <div class="box" style="color:gray">
            <p class="stats-number" id="deceasedCount">{{stats.stats.deceased}}</p>
            <p>Deceased</p>
          </div>
        </div>
        <hr/>
        <p class="center">Total</p>
        <div class="row stats-wrapper">  

         <div class="box">
          <p class="stats-number" id="deathCount">{{stats.stats.totalConfirmed}}</p>
          <p>Confirmed</p>
        </div>
        <div class="box" style="">
          <p class="stats-number" id="awaitedCount">{{stats.stats.totalRecovered}}</p>
          <p>Recovered</p>
        </div>
        <div class="box" style="">
          <p class="stats-number" id="totalSamplesCount">{{stats.stats.totalDeceased}}</p>
          <p>Deceased</p>
        </div>
        <div class="box" style="">
          <p class="stats-number" id="stateCount">{{stats.stats.totalVaccinated}}<span></span></p>
          <p>Vaccinated</p>
        </div>
      </div>
    </script>
    <hr/>

    <div class="column-wrapper">
      Positive Cases Trend 
      <canvas id="DAILY" width="400" height="400"></canvas>
    </div>
    <br/>
    <hr/>
    <p style="text-align:center">Bagalkot District Corona Helpline No: <br/>08354-236240, 08354-236240/1077 <br/>
    </span>
  </p>
  <p style="text-align:center">Note: Data fetched from covid19india.org, may differ from State Govt. numbers.
  </p>

  

  <script src="js/jquery.min.js"></script>
  <!-- Adsesnse  -->
 	<!--   <script data-ad-client="ca-pub-7389348172038480" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
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
  $(document).ready(function(){
    var statsDataUrl  ="https://covid19.nammabagalkot.in/getJson.php?f=data/statsData";
    var dailyDataUrl  ="https://covid19.nammabagalkot.in/getJson.php?f=data/dailyData";

    var d = new Date();
    d.setMinutes(d.getMinutes() - 5);                 
    var storageDate = localStorage.getItem("storedAtIndex");
    var sDate = new Date(storageDate);

    console.log("Fetched from api, calling function now.");
    $.get(statsDataUrl,function(data){
      updateCounts(data);
      ;
    });	

    $.get(dailyDataUrl,function(data){
      drawDailyGraph(data);
      ;
    }); 





    function updateCounts(data){			
      $("#lastupdated").html(data.lastupdated);

      var source = document.getElementById("stats-template").innerHTML;
      var template = Handlebars.compile(source);
      var context = {stats:data};
      var html = template(context);
      console.log(data);
      $("#stats-container").html(html);
    }





    function drawDailyGraph(dailyData){
      console.log(dailyData);
      /* DAILY GRAPH */
      var dailyDataCopy = dailyData;
      Object.keys(dailyDataCopy).map(function(key, index) {
        dailyDataCopy[key] = dailyDataCopy[key].confirmed;
      });
      console.log(dailyDataCopy);
      var ctx = document.getElementById('DAILY').getContext('2d');
      var config = {
        type: 'bar',
        data: {
          labels: Object.keys(dailyData),
          datasets: [{
            label: 'Postive Cases Trend',
            data: Object.values(dailyDataCopy),
        // backgroundColor: 
        borderColor: ["#c45850"],
      }]
    },

    options: {
      scales: {
        xAxes: [{
          type: 'time',
          distribution: 'linear'
        }],
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      },
      plugins: {
        colorschemes: {
          scheme: 'brewer.SetTwo5'
        }
      }
    }
  };

  var chart = new Chart(ctx, config);
  /* End Daily Trend*/


}

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
<!--  <script type="text/javascript" src="//ofgogoatan.com/apu.php?zoneid=3234318" async data-cfasync="false"></script> -->
<script type="text/javascript">

  if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
      navigator.serviceWorker.register('js/sw.js').then(function(registration) {
      // Registration was successful
      console.log('ServiceWorker registration successful with scope: ', registration.scope);
    }, function(err) {
      // registration failed :(
      console.log('ServiceWorker registration failed: ', err);
    });
    });
  }

</script>
</body>
</html>