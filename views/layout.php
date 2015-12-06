<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title><?php echo $title; ?></title>
  <meta name="description" content="Set up your own Tor-Relay in minutes with the Tor Relay Configurator.">
  <meta name="author" content="Felix Stein">

  <!-- Mobile Specific Metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FONT
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

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
      <div class="twelve columns">
        <h1><a href="/">Tor Relay Configurator</a></h1>
        <p>Get your own Tor Relay up and running in 5 minutes. <a href="https://www.torproject.org/about/overview.html.en" target="_blank">What is Tor?</a></p>
      </div>
    </div>
  </div>

  <?php echo $main_content; ?>

  <div class="container footer">
    <div class="row">
      <div class="ten columns offset-by-one">
        <p>
          If you have a problem/question/suggestion email me at <b>mail [at] flxn [dot] de</b> | <a href="https://flxn.de">More of my stuff</a>
          </p>
          <p>
            <a href="https://twitter.com/torrelayco" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @torrelayco</a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
            <div id="donatebtndiv">
              <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                <input type="hidden" name="cmd" value="_s-xclick">
                <input type="hidden" name="hosted_button_id" value="VFCWGXE2SPM7C">
                <input type="image" src="https://tor-relay.co/donatebutton.png" border="0" name="submit" alt="Jetzt einfach, schnell und sicher online bezahlen – mit PayPal.">
                <img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
              </form>
            </div>
          </p>


      </div>
    </div>
  </div>

  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="js/main.js"></script>
  <!-- End Document
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  </body>

  </html>
