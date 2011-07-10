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

  // Untyped response
  $data= $client->execute($request);
  
  // Typed response
  $data= $client->execute('com.github.Issue[]', $request);
?>
```

Inspiration
-----------
The RestSharp project - https://github.com/johnsheehan/RestSharp
