Hash redirect
--
Redirects URLs of the form `/base/-/resource` to `/base/#/resource`. Can be useful when pushing hash-URLs through redirects.

Configuration:

```ini
[app]
mappings="/base:web|/base/-:redirect"

[app::web]
; Here's your website using hash-URLs

[app::redirect]
class="scriptlet.HashRedirect"
```