  <!-- Primary Page Layout -->
  <div class="container">
    <div class="row">
      <div class="twelve columns">
        <h2>0) Prerequisites</h2>
          <h3>Hosting</h3>
          <p>
          You can run your Tor relay on every supported linux machine that you have SSH access to, be it in your home, a virtual server, or a dedicated server.
          <br> But not every hoster or ISP allows Tor relays in their network.
          <table class="u-full-width">
            <thead>
              <tr>
                <th>Name</th>
                <th>Server Location</th>
                <th>Middle Node (Relay)</th>
                <th>Exit Node</th>
                <th>Link</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><a href="http://partners.webmasterplan.com/click.asp?ref=750458&site=4208&type=text&tnb=31">Contabo</a></td>
                <td>DE</td>
                <td>yes</td>
                <td>yes</td>
                <td><a href="http://partners.webmasterplan.com/click.asp?ref=750458&site=4208&type=text&tnb=31">View Page</a></td>
              </tr>
              <tr>
                <td><a href="https://m.do.co/c/7a1a3669128b">Digital Ocean</a></td>
                <td>US, UK, FR, NL, ...</td>
                <td>yes</td>
                <td>no</td>
                <td><a href="https://m.do.co/c/7a1a3669128b">View Page</a></td>
              </tr>
              <tr>
                <td><a href="https://panel.linevast.de/aff.php?aff=416">Linevast</a></td>
                <td>DE</td>
                <td>yes</td>
                <td>no</td>
                <td><a href="https://panel.linevast.de/aff.php?aff=416">View Page</a></td>
              </tr>
              <tr>
                <td><a href="https://www.yourserver.se/portal/aff.php?aff=329">Yourserver</a></td>
                <td>SWE, LVA</td>
                <td>yes</td>
                <td>no</td>
                <td><a href="https://www.yourserver.se/portal/aff.php?aff=329">View Page</a></td>
              </tr>
              <tr>
                <td><a href="https://koddos.net/clients/aff.php?aff=636">KoDDos</a></td>
                <td>NL, HKG</td>
                <td>yes</td>
                <td>yes</td>
                <td><a href="https://koddos.net/clients/aff.php?aff=636">View Page</a></td>
              </tr>
            </tbody>
          </table>
          <i>The links in the table above are affiliate links. If you want to support this page you can purchase a product through one of these links and I will get a small percentage of your sale value. 100% of the money will be used for maintenance of this site and my own Tor relays.</i>
          <i>Please read the Terms of Service of the providers before signing up. Even if they allowed it in the past I do not take any responsibility if they close your account for deploying Tor.</i>
          <br> You can find a comprehensive list of Tor-friendly companies on the <a href="https://trac.torproject.org/projects/tor/wiki/doc/GoodBadISPs" target="_blank">official Tor wiki</a>.
         </p>
         <h3>Sudo</h3>
         <p>In order to run correctly the install script requires that the sudo command is installed on your server.
           <br>To check if it is already installed simply run <code>sudo</code> in your terminal. If you get a response like 
           <code>-bash: sudo: command not found</code> follow these steps on how to install it: <a href="/install-sudo-on-debian">Sudo installation tutorial</a>
         </p>
         <h3>Curl</h3>
         <p>To download the script to your server you also need curl.
           <br> To install it run the following command: <code>sudo apt install curl</code>.</p>
      </div>
    </div>

    <div class="row">
      <div class="twelve columns">
        <h2>1) Configuration</h2>
        <form action="/" method="post" id="mainform">
          <label>Operating System*<sup>1</sup> (Currently Ubuntu and Debian only. More options in the future)</label>
          <select name="os" id="os-select">
            <option value="jessie">Debian oldstable (jessie)</option>
            <option value="stretch" selected="selected">Debian stable (stretch)</option>
            <option value="buster">Debian testing (buster)</option>
            <option value="sid">Debian unstable (sid)</option>
            <option value="trusty">Ubuntu Trusty Tahr (14.04 LTS)</option>
            <option value="xenial">Ubuntu Xenial Xerus (16.04 LTS)</option>
            <option value="artful">Ubuntu Artful Aardvark (17.10)</option>
            <option value="bionic">Ubuntu Bionic Beaver (18.04 LTS)</option>
          </select>

          <label>Tor node type*</label>
          <label class="u-full-width">
            <input type="radio" name="node-type" value="relay" checked>
            <span class="label-body">Relay
              <span style="font-style:italic;font-size:12px;">(Default; You probably want to keep this selected)</span>
            </span>
          </label>
          <label class="u-full-width">
            <input type="radio" name="node-type" value="bridge">
            <span class="label-body">Bridge
              <span style="font-style:italic;font-size:12px;"></span>
            </span>
          </label>
          <label class="u-full-width">
            <input type="radio" name="node-type" value="exit">
            <span class="label-body">Exit Node
              <span style="font-style:italic;font-size:12px;">(Following <a href="https://trac.torproject.org/projects/tor/wiki/doc/ReducedExitPolicy">ReducedExitPolicy</a>)</span>
            </span>
          </label>
          <p id="exit-info" style="background: rgba(255,0,0,0.1)">
            Running an Exit Node is the best way to help the Tor network but you have to be aware of the risks.
            <br> More Info:
            <a class="italic" href="https://trac.torproject.org/projects/tor/wiki/doc/TorExitGuidelines" target="_blank">Tor Exit Guidelines</a>,
            <a class="italic" href="https://blog.torproject.org/running-exit-node" target="_blank">Tips for Running an Exit Node with Minimal Harassment</a>
            <br>
            <br>
            The script will download a notice about exit nodes (<a href="https://gitweb.torproject.org/tor.git/plain/contrib/operator-tools/tor-exit-notice.html">tor-exit-note.html</a>)
            to <code>/etc/tor/tor-exit-notice.html</code>
            that will be published on your selected DirPort (Default: 80).
            <br>
            This is the US version of the file. Please update the sections accordingly to match the legislation of your country.
            <br>
            Please also replace FIXME_YOUR_EMAIL_ADDRESS with your mail address!
          </p>

            <div id="field-relayname">
              <label>Relay Name*
                <span style="font-style:italic;font-size:12px;">(1 to 19 characters, only letters and numbers, no spaces or other special characters)</span>
              </label>
              <input type="text" name="relayname" class="u-full-width" placeholder="The nickname of your relay">
            </div>

            <div id="field-contactinfo">
              <label>Contact Info*</label>
              <input type="text" name="contactinfo" class="u-full-width" placeholder="Your email address (slight obfuscation reduces spam)">
            </div>

            <div id="field-trc-track">
              <label class="u-full-width">
                <input type="checkbox" name="trc-track" checked>
                <span class="label-body">Enable statistics<sup>2</sup> (This will add <code>[tor-relay.co]</code> to your ContactInfo field.)</span>
              </label>
            </div>

            <div id="field-ipv6">
              <label class="u-full-width">
                <input type="checkbox" name="ipv6" checked>
                <span class="label-body">Enable IPv6 support (<a href="https://trac.torproject.org/projects/tor/wiki/doc/IPv6RelayHowto" target="_blank">More info</a>)</span>
              </label>
            </div>

            <div id="field-unattended-upgrades">
              <label class="u-full-width">
                <input type="checkbox" name="unattended-upgrades" checked>
                <span class="label-body">Enable unattended upgrades (Automatically install latest security patches and Tor updates)</span>
              </label>
            </div>

            <div class="row">
              <div class="six columns">
                <div id="field-orport">
                  <label for="orport">ORPort*</label>
                  <input type="text"  name="orport" class="u-full-width" value="9001" id="orport" required="true">
                </div>
              </div>

              <div class="six columns">
                <div id="field-dirport">
                  <label for="dirport">DirPort</label>
                  <input type="text" name="dirport" class="u-full-width" value="9030" id="dirport">
                </div>
              </div>
            </div>

            <label for="traffic-total">Total (Up + Down) monthly traffic limit (empty for no limit)</label>
            <div class="row">
              <div class="ten columns">
                <input type="text" name="traffic-limit" class="only-numbers u-full-width" placeholder="e.g. 10TB (= 5TB Upstream traffic + 5TB Downstream traffic)">
              </div>
              <div class="two columns">
                <select class="u-full-width" name="traffic-unit">
                  <option value="GB">GB</option>
                  <option value="TB">TB</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="six columns">
                <label for="bandwidth-rate">Maximum bandwidth (empty for no limit)</label>
                <input type="text" name="bandwidth-rate" class="only-numbers u-full-width" placeholder="Value in Mb/s (Megabits/second)">
              </div>
              <div class="six columns">
                <label for="bandwidth-burst">Maximum burst bandwidth</label>
                <input type="text" name="bandwidth-burst" class="only-numbers u-full-width" placeholder="Value in Mb/s (Megabits/second)">
              </div>
            </div>

            <label class="u-full-width">
              <input type="checkbox" name="enable-arm">
              <span class="label-body">Enable monitoring through <a href="https://www.atagar.com/arm/" target="_blank">arm</a></span>
            </label>

          <input id="submit" type="submit" class="button-primary u-pull-right" name="submit" value="submit">
        </form>
        <?php if ($errors) : ?>
          <p style="color: red; font-weight: bold; font-size: 1.75rem;">
            Error: <?php echo $errors; ?>
          </p>
        <?php endif; ?>

        <br>
        <br>
        <p>
          <i>
            By clicking submit you agree that I take no responsibility for any damages that might occur when running the Tor-Relay.co setup script.
          </i>
        </p>
          <p>* required values</p>
          <p><sup>1</sup> To find your OS version run
            <pre><code>lsb_release -a</code></pre>
            if this does not work try
            <pre><code>cat /etc/issue</code></pre>
          </p>
          <p>
            <sup>2</sup> If this is checked your relay uptime and bandwidth will be counted in the global statistics panel on the top right. This is anonymous. No information will be saved.
          </p>
      </div>
    </div>

  </div>
