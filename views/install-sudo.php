<div class="container">
    <div class="row">
        <div class="twelve columns">
            <p></p>
            <h1>Installing sudo</h1>
            <p>
                Log into your server as the root user.
                First update your package repository data:
                <pre><code>apt update</code></pre>
                Then install sudo with:
                <pre><code>apt install sudo</code></pre>
                Sudo is now installed, but by default only the root user can use it, which is not what we want.
                On installation sudo adds a new user group "sudo" to the system. All users in that group are allowed to run the sudo command so we have to add your user to this grup.
                You can do this with the following command:
                <pre><code>adduser foo sudo</code></pre>
                This adds a user called "foo" to the sudo group. Obviously you have to replace "foo" with your username.
                <br>Now you log out of your server and log in with your user and you will have full root access through the sudo command.
                <br>This is a much safer way to run a command as root than by directly logging in as the root user.
            </p>
        </div>
    </div>
</div>