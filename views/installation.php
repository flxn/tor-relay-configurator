  <!-- Primary Page Layout -->
  <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
  <div class="container">
    <div class="row">
      <div class="twelve columns">
        <div class="row">
          <div class="twelve columns">
            <h2>2) Installation <a href="https://twitter.com/share" class="twitter-share-button"{count} data-url="https://tor-relay.co" data-text="I'm now operating my own Tor Relay. Set up yours today!" data-via="torrelayco" data-size="large" data-hashtags="SupportTor">Share</a></h2>
            <p>
              Run the following command to set up your Tor relay:<br>
              <i>Only run this script if your hoster/ISP allows Tor!</i>
            </p>
            <pre><code id="shellcode">curl https://tor-relay.co/nf/<?=$configFile?> | bash</code></pre>
            <p>
              Or if you don't trust this page or your network connection and you want to inspect the file before running it:
            </p>
            <pre><code id="shellcode">wget https://tor-relay.co/nf/<?=$configFile?>&#10;less <?=$configFile?>&#10;bash <?=$configFile?></code></pre>
            <?php if($nyx): ?>
            <p>
              To monitor your relay start nyx with
              <pre><code>sudo -u debian-tor nyx</code></pre>
            </p>
            <?php endif; ?>
            <h3>Torrc Preview</h3>
            <pre><code><?php echo htmlspecialchars($torrc, ENT_QUOTES, 'UTF-8'); ?></code></pre>
          </div>
        </div>
        <div class="row">
          <h2>3) Optional Setup and Tips</h2>
          <p>
            Here are a few things you can do to ensure the security of your relay.
          </p>
          <h3>Updates</h3>
          <p>You should regularly install security updates for your operating system.</p>
          <p>
              On Ubuntu and Debian you can update your system by running
              <pre><code>apt-get update && apt-get upgrade</code></pre>
          </p>
          <h3>SSH</h3>
          <p>When you run a relay server you will see an increase in SSH login attempts.<br>
              To increase sever security you should disable root login via password or only allow public-key access in general.<br>
              <br>
              First make sure that you added a user you can login with.<br>
              <a href="https://www.digitalocean.com/community/tutorials/initial-server-setup-with-ubuntu-14-04">The Digitalocean Community provides some tips for initial server setup.</a>
                <br>
                <br>
              To disable logins as root user edit this file as root:
              <pre><code id="shellcode">nano /etc/ssh/sshd_config</code></pre>
              Search for the line that says
              <pre><code id="shellcode">PermitRootLogin yes</code></pre>
              And change it to
              <pre><code id="shellcode">PermitRootLogin without-password</code></pre>
              After that restart the SSH service
              <pre><code id="shellcode">service ssh restart</code></pre>
          </p>
          <h3>Services</h3>
          <p>Don't run any unnecessary services. It is recommended to only run Tor itself on your relay server. This minimizes potential attack vectors.<br>
          A static webpage should not be a problem but you probably don't want to run your Wordpress on a Tor server.</p>
          </ul>
        </div>
      </div>
    </div>
  </div>
