  <!-- Primary Page Layout -->
  <div class="container">
    <div class="columns">
      <div class="column">
        <div class="columns">
          <div class="column">
            <h2 class="title">Installation</h2>
            <p>
              Run the following command to set up your Tor relay:<br>
              <i>Only run this script if your hoster/ISP allows Tor!</i>
            </p>
            <pre><code id="shellcode">curl https://tor-relay.co/nf/<?= $configFile ?> | bash</code></pre><br/>
            <p>
              Or if you don't trust this page or your network connection and you want to inspect the file before running it:
            </p>
            <pre><code id="shellcode">wget https://tor-relay.co/nf/<?= $configFile ?>&#10;less <?= $configFile ?>&#10;bash <?= $configFile ?></code></pre><br/>
            <?php if ($nyx) : ?>
              <p>
                To monitor your relay start nyx with
                <pre><code>sudo -u debian-tor nyx</code></pre>
              </p>
            <?php endif; ?>
            <h3 class="subtitle">Torrc Preview</h3>
            <pre><code><?php echo htmlspecialchars($torrc, ENT_QUOTES, 'UTF-8'); ?></code></pre><br/>
            <h3 class="subtitle">Spread the word</h3>
            <p>Share your contribution with your friends to help make the Tor network even bigger.</p>
            <div class="shariff" data-lang="en" data-title="I am now running my own Tor node. Set up your own:" data-theme="white" data-orientation="horizontal" data-twitter-via="torrelayco" data-services="['twitter', 'facebook', 'threema', 'telegram', 'whatsapp', 'mail']"></div>
          </div>
        </div>
        <div class="columns">
          <div class="column">
            <h2 class="title">Optional Setup and Tips</h2>
            <p>
              Here are a few things you can do to ensure the security of your relay.
            </p>
            <h3 class="subtitle">Updates</h3>
            <p>You should regularly install security updates for your operating system.</p>
            <p>
              On Ubuntu and Debian you can update your system by running
              <pre><code>apt-get update && apt-get upgrade</code></pre><br/>
            </p>
            <h3 class="subtitle">SSH</h3>
            <p>When you run a relay server you will see an increase in SSH login attempts.<br>
              To increase sever security you should disable root login via password or only allow public-key access in general.<br>
              <br>
              First make sure that you added a user you can login with.<br>
              <a href="https://www.digitalocean.com/community/tutorials/initial-server-setup-with-ubuntu-14-04">The Digitalocean Community provides some tips for initial server setup.</a>
              <br>
              <br>
              To disable logins as root user edit this file as root:
              <pre><code id="shellcode">nano /etc/ssh/sshd_config</code></pre><br/>
              Search for the line that says
              <pre><code id="shellcode">PermitRootLogin yes</code></pre><br/>
              And change it to
              <pre><code id="shellcode">PermitRootLogin without-password</code></pre><br/>
              After that restart the SSH service
              <pre><code id="shellcode">service ssh restart</code></pre><br/>
            </p>
            <h3 class="subtitle">Services</h3>
            <p>Don't run any unnecessary services. It is recommended to only run Tor itself on your relay server. This minimizes potential attack vectors.<br>
              A static webpage should not be a problem but you probably don't want to run your Wordpress on a Tor server.</p>
            </ul>
          </div>

        </div>
      </div>
    </div>
  </div>