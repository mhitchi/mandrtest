# M&R Starter Template

## SFTP Settings
This is set to grab all of wp-content, but you might want to only track the theme.

Adjust name, host, username, password, remotePath as needed.

```
{
    "name": "starter",
    "host": "",
    "protocol": "sftp",
    "port": 2222,
    "username": "",
    "password": "",
    "remotePath": "/wp-content/",
    "watcher": {
        "files": "{themes/mandr-4500/style.css,themes/mandr-4500/assets/js/all.min.js}",
        "autoUpload": true
    },
    "uploadOnSave": true,
    "ignore": [
        ".vscode",
        ".git",
        ".DS_Store",
        "*.sql",
        "node_modules",
        "acf-json",
        "!/plugins",
        "/plugins/*",
        "!/plugins/mandr-page-scripts",
        "!/plugins/mandr-adv-blog",
        "!/mu-plugins",
        "/mu-plugins/*",
        "!/mu-plugins/aqua-resizer-extension",
        "!/mu-plugins/login-logo",
        "!/mu-plugins/mandr-cpt",
        "!/mu-plugins/mandr-custom-colorpicker",
        "!/mu-plugins/mandr-custom-dashboard",
        "!/mu-plugins/mandr-role-restrictions",
        "!/mu-plugins/mu-load.php",
        "/uploads",
        "/upgrade",
        "advanced-cache.php",
        "object-cache.php",
        "/index.php",
        "/themes/index.php"
    ]
}
```
