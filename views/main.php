  <!-- Primary Page Layout -->
  <div class="container">
    <div class="columns">
      <div class="column">
        <h2 class="title">Prerequisites</h2>
        <h3 class="subtitle">Hosting</h3>
        <p>
          You can run your Tor relay on every supported linux machine that you have SSH access to, be it in your home, a virtual server, or a dedicated server.
          <br> But not every hoster or ISP allows Tor relays in their network.
          <table class="table is-fullwidth">
            <thead>
              <tr>
                <th>Name</th>
                <th>Server Location</th>
                <th>Middle Node (Relay)</th>
                <th>Exit Node</th>
                <th>Bitcoin</th>
                <th>Link</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><a href="https://panel.linevast.de/aff.php?aff=416" target="_blank">Linevast</a></td>
                <td>Germany</td>
                <td>yes</td>
                <td>no</td>
                <td>yes</td>
                <td><a href="https://panel.linevast.de/aff.php?aff=416" target="_blank">View Page</a></td>
              </tr>
              <tr>
                <td><a href="https://billing.flokinet.is/aff.php?aff=226" target="_blank">Flokinet</a></td>
                <td>Romania, Iceland, Finland</td>
                <td>yes</td>
                <td>yes</td>
                <td>yes</td>
                <td><a href="https://billing.flokinet.is/aff.php?aff=226" target="_blank">View Page</a></td>
              </tr>
              <tr>
                <td><a href="https://www.yourserver.se/portal/aff.php?aff=329" target="_blank">Yourserver</a></td>
                <td>Sweden, Latvia</td>
                <td>yes</td>
                <td>no</td>
                <td>yes</td>
                <td><a href="https://www.yourserver.se/portal/aff.php?aff=329" target="_blank">View Page</a></td>
              </tr>
              <tr>
                <td><a href="https://www.pulseservers.com/billing/aff.php?aff=75" target="_blank">PulseServers</a></td>
                <td>Canada, United Kingdom</td>
                <td>yes</td>
                <td>yes</td>
                <td>yes</td>
                <td><a href="https://www.pulseservers.com/billing/aff.php?aff=75" target="_blank">View Page</a></td>
              </tr>
              <tr>
                <td><a href="https://clients.liteserver.nl/aff.php?aff=206" target="_blank">LiteServer</a></td>
                <td>Netherlands</td>
                <td>yes</td>
                <td><a href="https://liteserver.nl/acceptable-usage-policy/" target="_blank">yes</a></td>
                <td>yes</td>
                <td><a href="https://clients.liteserver.nl/aff.php?aff=206" target="_blank">View Page</a></td>
              </tr>
              <tr>
                <td><a href="https://m.do.co/c/7a1a3669128b" target="_blank">DigitalOcean</a></td>
                <td>United States, Netherlands,<br /> Singapore, United Kingdom,<br /> Germany, Canada, India</td>
                <td>yes</td>
                <td>no</td>
                <td>no</td>
                <td><a href="https://m.do.co/c/7a1a3669128b" target="_blank">View Page</a></td>
              </tr>
            </tbody>
          </table>
          <p>
            <i>The links in the table above are affiliate links. If you want to support this page you can purchase a product through one of these links and I will get a small percentage of your sale value. 100% of the money will be used for maintenance of this site and my own Tor relays.</i><br />
            <i>Please read the Terms of Service of the providers before signing up. Even if they allowed it in the past I do not take any responsibility if they close your account for deploying Tor.</i>
            <br> You can find a comprehensive list of Tor-friendly companies on the <a href="https://trac.torproject.org/projects/tor/wiki/doc/GoodBadISPs" target="_blank">official Tor wiki</a>.
          </p>
        </p>
        <h3 class="subtitle">Sudo</h3>
        <p>In order to run correctly the install script requires that the sudo command is installed on your server.
          <br>To check if it is already installed simply run <code>sudo</code> in your terminal. If you get a response like
          <code>-bash: sudo: command not found</code> follow these steps on how to install it: <a href="/install-sudo-on-debian">Sudo installation tutorial</a>
        </p>
        <h3 class="subtitle">Curl</h3>
        <p>To download the script to your server you also need curl.
          <br> To install it run the following command: <code>sudo apt install curl</code>.</p>
      </div>
      <div class="column is-3">
        <h2 class="title">Support Tor</h2>
        <p>If you don't want to run your own server because but still want to help Tor here are some things you can do:</p>
        <p>
          <strong>1.</strong> <a href="https://donate.torproject.org/" target="_blank" rel="noopener noreferrer">Donate to the Tor Project</a><br />
          <span>This will directly benefit the people working for the Tor project and fund development and outreach.</span>
        </p>
        <p>
          <strong>2.</strong> <a href="https://torservers.net/donate.html" target="_blank" rel="noopener noreferrer">Donate to Torservers.net</a><br />
          <span>They maintain many high-speed Tor nodes, your money will be used to increase Tor capacity.</span>
        </p>
        <p>
          <strong>3.</strong> Share this page with your friends. Maybe one of them wants to run their own server.
        </p>
        <p>
          <strong>4.</strong> If you don't know what to do with your money you can also <a href="https://ko-fi.com/flxn256" target="_blank" rel="noopener noreferrer">Donate to me directly</a>.
          I will use the money to keep this site running. But please donate to the others first.
        </p>
      </div>
    </div>
    <hr />
    <div class="columns is-centered">
      <div class="column is-10">
        <div class="config-section box">
          <h2 class="title">Configuration</h2>
          <form action="/" method="post" id="mainform">
            <div class="field">
              <label for="" class="label"></label>
              <div class="control">

              </div>
            </div>

            <div class="field">
              <label for="os" class="label">Operating System*<sup>1</sup> (Currently Ubuntu and Debian only. More options in the future)</label>
              <div class="control">
                <div class="select">
                  <select name="os" id="os-select">
                    <option value="jessie">Debian oldstable (jessie)</option>
                    <option value="stretch" selected="selected">Debian 9 (stretch)</option>
                    <option value="buster">Debian 10 (buster)</option>
                    <option value="sid">Debian unstable (sid)</option>
                    <option value="trusty">Ubuntu Trusty Tahr (14.04 LTS)</option>
                    <option value="xenial">Ubuntu Xenial Xerus (16.04 LTS)</option>
                    <option value="artful">Ubuntu Artful Aardvark (17.10)</option>
                    <option value="bionic">Ubuntu Bionic Beaver (18.04 LTS)</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="field">
              <label for="" class="label">Tor node type*</label>
              <div class="control">
                <label class="">
                  <input type="radio" name="node-type" value="relay" checked>
                  <span class="label-body">Relay
                    <span style="font-style:italic;font-size:12px;">(Default; You probably want to keep this selected)</span>
                  </span>
                </label>
                <br />
                <label class="">
                  <input type="radio" name="node-type" value="bridge">
                  <span class="label-body">Bridge
                    <span style="font-style:italic;font-size:12px;"></span>
                  </span>
                </label>
                <br />
                <label class="">
                  <input type="radio" name="node-type" value="exit">
                  <span class="label-body">Exit Node
                    <span style="font-style:italic;font-size:12px;">(Following <a href="https://trac.torproject.org/projects/tor/wiki/doc/ReducedExitPolicy">ReducedExitPolicy</a>)</span>
                  </span>
                </label>
              </div>
            </div>

            <p id="exit-info" class="notification is-warning">
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

            <div id="field-relayname" class="field">
              <label for="" class="label">Relay Name*
                <span style="font-style:italic;font-size:12px;">(1 to 19 characters, only letters and numbers, no spaces or other special characters)</span></label>
              <div class="control">
                <input type="text" name="relayname" class="input" placeholder="The nickname of your relay">

              </div>
            </div>

            <div id="field-contactinfo" class="field">
              <label class="label">Contact Info*</label>

              <div class="control">
                <input type="text" name="contactinfo" class="input" placeholder="Your email address (slight obfuscation reduces spam)">
              </div>
            </div>

            <div id="field-trc-track" class="field">
              <div class="control">
                <label>
                  <input type="checkbox" name="trc-track" checked>
                  <span class="label-body">Enable statistics<sup>2</sup> (This will add <code>[tor-relay.co]</code> to your ContactInfo field.)</span>
                </label>
              </div>

            </div>

            <div id="field-ipv6" class="field">
              <div class="control">
                <label>
                  <input type="checkbox" name="ipv6" checked>
                  <span class="label-body">Enable IPv6 support (<a href="https://trac.torproject.org/projects/tor/wiki/doc/IPv6RelayHowto" target="_blank">More info</a>)</span>
                </label>
              </div>
            </div>

            <div id="field-unattended-upgrades" class="field">
              <div class="control">
                <label>
                  <input type="checkbox" name="unattended-upgrades" checked>
                  <span class="label-body">Enable unattended upgrades (Automatically install latest security patches and Tor updates)</span>
                </label>
              </div>
            </div>

            <div class="columns">
              <div class="column">
                <div id="field-orport" class="field">
                  <label for="orport" class="label">ORPort*</label>
                  <div class="control">
                    <input type="text" name="orport" class="input" value="9001" id="orport" required="true">
                  </div>

                </div>
              </div>

              <div class="column">
                <div id="field-dirport" class="field">
                  <label for="dirport" class="label">DirPort</label>
                  <div class="control">
                    <input type="text" name="dirport" class="input" value="9030" id="dirport">
                  </div>

                </div>
              </div>

              <div class="column">
                <div id="field-obfs4port" class="field">
                  <label for="obfs4port" class="label">Obfs4 Port*</label>
                  <div class="control">
                    <input type="text" name="obfs4port" class="input" value="9030" id="obfs4port">
                  </div>
                </div>
              </div>
            </div>

            <div class="field">
              <label for="traffic-total" class="label">Total (Up + Down) monthly traffic limit (empty for no limit)</label>
              <div class="control">
                <div class="columns">
                  <div class="is-10 column">
                    <input type="text" name="traffic-limit" class="input only-numbers " placeholder="e.g. 10TB (= 5TB Upstream traffic + 5TB Downstream traffic)">
                  </div>
                  <div class="is-2 column">
                    <div class="control">
                      <div class="select">
                        <select class="" name="traffic-unit">
                          <option value="GB">GB</option>
                          <option value="TB">TB</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="columns">
              <div class="column">
                <div class="field">
                  <label for="bandwidth-rate" class="label">Maximum bandwidth (empty for no limit)</label>
                  <div class="control">
                    <input type="text" name="bandwidth-rate" class="only-numbers input" placeholder="Value in Mb/s (Megabits/second)">
                  </div>

                </div>
              </div>
              <div class="column">
                <div class="field">
                  <label for="bandwidth-burst" class="label">Maximum burst bandwidth</label>
                  <div class="control">
                    <input type="text" name="bandwidth-burst" class="only-numbers input" placeholder="Value in Mb/s (Megabits/second)">

                  </div>
                </div>

              </div>
            </div>

            <div class="field">
              <div class="control">
                <label>
                  <input type="checkbox" name="enable-nyx">
                  <span class="label-body">Enable monitoring through <a href="https://nyx.torproject.org/" target="_blank">nyx</a></span>
                </label>

              </div>
            </div>

            <input id="submit" type="submit" class="button is-primary is-medium" name="submit" value="Generate Config">
          </form>
          <?php if ($errors) : ?>
            <p style="color: red; font-weight: bold; font-size: 1.75rem;">
              Error: <?php echo $errors; ?>
            </p>
          <?php endif; ?>
          <br />
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


  </div>