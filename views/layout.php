<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>
    <?php echo $title; ?>
  </title>
  <meta name="description" content="Set up your own Tor-Relay in minutes with the Tor Relay Configurator.">
  <meta name="author" content="Felix Stein">

  <!-- Mobile Specific Metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FONT
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,600" rel="stylesheet" type="text/css">

  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/skeleton.css">
  <link rel="stylesheet" href="css/style.css">

  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="apple-touch-icon" sizes="57x57" href="/img/apple-touch-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="/img/apple-touch-icon-60x60.png">
  <link rel="icon" type="image/png" href="/img/favicon-32x32.png" sizes="32x32">
  <link rel="icon" type="image/png" href="/img/favicon-16x16.png" sizes="16x16">
  <link rel="manifest" href="/manifest.json">
  <link rel="mask-icon" href="/img/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#00a300">
  <meta name="theme-color" content="#ffffff">

</head>

<body>
  <div class="container title">
    <div class="row">
      <div class="seven columns">
        <h1><a href="/">Tor Relay Configurator</a></h1>
        <p>
          Get your own Tor Relay up and running in 5 minutes. <a href="https://www.torproject.org/about/overview.html.en" target="_blank">What is Tor?</a><br/>
          <a href="https://flxn.de/blog/tor-relay-tutorial" target="_blank">Visit my blog</a> for a tutorial on how to use the tor-relay.co generator.
        </p>
      </div>
      <div class="five columns statistics" title="Statistics updated daily">
        <div class="row">
          <div class="four columns">
            <span class="statvalues"><?=$serverCount?></span>
            Running<br>Servers
          </div>
          <div class="four columns">
            <span class="statvalues"><?=$combinedUptime?></span>
            Combined Uptime
          </div>
          <div class="four columns">
            <span class="statvalues"><?=$combinedBandwidth?></span>
            Combined Bandwidth
          </div>
        </div>
      </div>
    </div>

      <div class="row">
        <div class="four columns">
          <canvas id="chartNodes" height="240"></canvas>
        </div>
        <div class="four columns">
            <canvas id="chartBandwidth" height="240"></canvas>
        </div>
        <div class="four columns">
            <div class="topnodes">
                <strong>Top 5 Nodes</strong>
                <ul>
                    <?php for($i = 0; $i < 5; $i++){ ?>
                        <li><?=$nodes[$i]['name']?> (<?=$nodes[$i]['bandwidth']?>Mb/s)</li>
                    <?php } ?>
                </ul>
            </div>
        </div>
      </div>
  </div>

  <?php echo $main_content; ?>

    <div class="container footer">
      <div class="row">
        <div class="twelve columns">
          <div class="row footer">
            If you have a problem/question/suggestion email me at <b>mail [at] flxn [dot] de</b> | <a href="https://flxn.de">More of my stuff</a>
          </div>
          <div class="row">
            <a href="https://ko-fi.com/flxn256" target="_blank">💵☕️ Buy me a coffee... or a tea, or a Club Mate (I actually don't like coffee)</a> | Website currently at commit: <a href="https://github.com/flxn/tor-relay-configurator/commit/<?=$currentCommit?>"><?=$currentCommit?></a>
          </div>
          <div class="row footer2">
            <div class="six columns offset-by-three">
              <div class="six columns">
                <!-- Place this tag where you want the button to render. -->
                <a class="github-button" href="https://github.com/flxn/tor-relay-configurator" data-style="mega" aria-label="flxn/tor-relay-configurator">View on GitHub</a>
              </div>
              <div class="six columns">
                <a href="https://twitter.com/torrelayco" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @torrelayco</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="js/moment.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script>
      var bandwidthChartData = <?=$bandwidthChartData?>;
      var nodesChartData = <?=$nodesChartData?>;
    </script>
    <script src="js/main.js"></script>
    <script async defer id="github-bjs" src="https://buttons.github.io/buttons.js"></script>
    <script>
      ! function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0],
          p = /^http:/.test(d.location) ? 'http' : 'https';
        if (!d.getElementById(id)) {
          js = d.createElement(s);
          js.id = id;
          js.src = p + '://platform.twitter.com/widgets.js';
          fjs.parentNode.insertBefore(js, fjs);
        }
      }(document, 'script', 'twitter-wjs');
    </script>
    <!-- Matomo -->
    <script type="text/javascript">
      var _paq = _paq || [];
      /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
      _paq.push(['trackPageView']);
      _paq.push(['enableLinkTracking']);
      (function() {
        var u="//analytics.flxn.de/";
        _paq.push(['setTrackerUrl', u+'p.php']);
        _paq.push(['setSiteId', '2']);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'p.js'; s.parentNode.insertBefore(g,s);
      })();
    </script>
    <!-- End Matomo Code -->
    <!-- End Document
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>

</html>
