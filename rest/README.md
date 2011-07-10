REST API
========
This is an experiment of what the XP Framework's REST API could look
like in the future.

Basic usage
-----------
The `RestClient` class forms the entry point:

```php
<?php
  uses('webservices.rest.RestClient');
  
  $client= new RestClient('https://api.github.com');
  
  // Basic auth
  $client= new RestClient('https://user:password@api.github.com');
  
  // Compose resource URL with segment parameters
  $request= new RestRequest('/repos/{user}/{repo}/issues');
  $request->addSegment('user', $user);
  $request->addSegment('repo', $repository);
  
  // Resource URL with parameters
  $request= new RestRequest('/issues');
  $request->addParameter('filter', 'assigned');

  // Add HTTP headers
  $request->addHeader('Accept-Language', 'de, en;q=0.7');

  // Untyped response
  $data= $client->execute($request);
  
  // Typed response, an array of Issue instances
  $data= $client->execute('com.github.api.v3.Issue[]', $request);
?>
```

Demo
----
To try out the [GitHub API](http://developer.github.com/) to retrieve issues
for a given user's project, execute:

```
$ xpcli cmd.github.IssuesOf user repo [-v]
```

Inspiration
-----------
The RestSharp project - https://github.com/johnsheehan/RestSharp
