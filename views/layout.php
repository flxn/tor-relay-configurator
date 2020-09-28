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

  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="/css/bulma.min.css">
  <link rel="stylesheet" href="/css/shariff.complete.css">
  <link rel="stylesheet" href="/css/style.css">

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
  <div class="container header">
    <div class="columns">
      <div class="column">
        <h1 class="title"><a href="/">Tor Relay Configurator</a></h1>
        <p class="subtitle">
          Get your own Tor Relay up and running in seconds.<br />
          <a href="https://www.torproject.org/about/overview.html.en" target="_blank">What is Tor?</a>
          | <a href="https://flxn.de" target="_blank">Who made this?</a>
          <!--<a href="https://flxn.de/posts/tor-relay-tutorial/" target="_blank">Visit my blog</a> for a tutorial on how to use the tor-relay.co generator.-->
        </p>
      </div>
      <div class="column" title="Statistics updated daily">
        <nav class="level box">
          <div class="level-item has-text-centered">
            <div>
              <p class="heading">Servers</p>
              <p class="title"><?= $serverCount ?></p>
            </div>
          </div>
          <div class="level-item has-text-centered">
            <div>
              <p class="heading">Uptime</p>
              <p class="title"><?= $combinedUptime ?></p>
            </div>
          </div>
          <div class="level-item has-text-centered">
            <div>
              <p class="heading">Bandwidth</p>
              <p class="title"><?= $combinedBandwidth ?></p>
            </div>
          </div>
        </nav>
      </div>
    </div>

    <div class="columns charts">
      <div class="column has-text-centered">
        <div class="box">
      <strong>Number of nodes</strong>

        <canvas id="chartNodes" class="chart" height="180"></canvas>
        </div>
      </div>
      <div class="column has-text-centered">
        <div class="box">
      <strong>Combined Bandwidth (Mb/s)</strong>

        <canvas id="chartBandwidth" class="chart" height="180"></canvas>
        </div>
      </div>
      <div class="column">
        <div class="topnodes box">
          <strong>🏆 Top 10 Nodes 🏆</strong>
          <ol>
            <?php if (count($nodes) >= 10) { ?>
              <li>🥇 <strong><?= $nodes[0]['nickname'] ?></strong> (<?= round($nodes[0]['bandwidth'] * 8 / 1000 / 1000) ?>Mb/s)</li>
              <li>🥈 <strong><?= $nodes[1]['nickname'] ?></strong> (<?= round($nodes[1]['bandwidth'] * 8 / 1000 / 1000) ?>Mb/s)</li>
              <li>🥉 <strong><?= $nodes[2]['nickname'] ?></strong> (<?= round($nodes[2]['bandwidth'] * 8 / 1000 / 1000) ?>Mb/s)</li>
              <?php for ($i = 3; $i < 10; $i++) { ?>
                <li><strong><?= $nodes[$i]['nickname'] ?></strong> (<?= round($nodes[$i]['bandwidth'] * 8 / 1000 / 1000) ?>Mb/s)</li>
              <?php } ?>
            <?php } ?>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <?php echo $main_content; ?>

  <footer class="footer">
    <div class="notification">
      <div class="columns">
        <div class="column is-1 is-size-3">🌈</div>
        <div class="column">Interested in development? Check out my newest side project <strong>landof.dev</strong> where you can <a href="https://landof.dev/awesome">discover GitHub repositories and development resources about hundreds of topics</a>.</div>
        <div class="column is-1 is-size-3">🌈</div>
      </div>
    </div>
    <div class="content has-text-centered">
      <p>
        If you have a problem/question/suggestion email me at <b>mail [at] flxn [dot] de</b>
        | <a href="https://flxn.de">More of my stuff</a>
        | <a href="https://github.com/flxn/tor-relay-configurator" rel="nofollow" role="button" aria-label="flxn/tor-relay-configurator">
          <span class="fab fa-github"></span>
          <span class="share_text">View this project on GitHub</span>
        </a>
      </p>
      <p>
        <a href="https://ko-fi.com/flxn256" target="_blank">💵☕️ Buy me a coffee... or a tea, or a Club Mate (I actually don't like coffee)</a> | Website currently at commit: <a href="https://github.com/flxn/tor-relay-configurator/commit/<?= $currentCommit ?>"><?= $currentCommit ?></a>
      </p>
      <div class="shariff" data-lang="en" data-title="Set up your own Tor node and contribute to privacy on the internet." data-theme="white" data-orientation="horizontal" data-twitter-via="torrelayco" data-services="['twitter', 'facebook', 'threema', 'telegram', 'whatsapp', 'mail']"></div>
    </div>
  </footer>

  <script src="/js/jquery.min.js"></script>
  <script src="/js/moment.min.js"></script>
  <script src="/js/Chart.min.js"></script>
  <script src="/js/shariff.min.js"></script>
  <script>
    var bandwidthChartData = <?= $bandwidthChartData ?>;
    var nodesChartData = <?= $nodesChartData ?>;
  </script>
  <script src="/js/main.js"></script>
  <!-- Matomo -->
  <script type="text/javascript">
    var _paq = _paq || [];
    /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function() {
      var u = "//analytics.flxn.de/";
      _paq.push(['setTrackerUrl', u + 'p.php']);
      _paq.push(['setSiteId', '2']);
      var d = document,
        g = d.createElement('script'),
        s = d.getElementsByTagName('script')[0];
      g.type = 'text/javascript';
      g.async = true;
      g.defer = true;
      g.src = u + 'p.js';
      s.parentNode.insertBefore(g, s);
    })();
  </script>
  <!-- End Matomo Code -->
  <!-- End Document
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>

</html>