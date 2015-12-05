# PHP Tor Relay Configurator
*Powering [Tor-Relay.co](https://tor-relay.co)*

---

## Setup
**SSL should alwys be used to secure ``curl | bash`` installation**

### Nginx
Add to server configuration
```
server {
    location / {
        try_files $uri $uri/ /index.php;
    }
}
```

### Apache
*should work out-of-the-box if ``.htaccess`` is enabled*
