#!/usr/bin/python

''' ***************************************************************************
    Most basic config
    ************************************************************************'''

mainconfigpath=     './etc'
mainconfigfile= 'default.ini'

''' ***************************************************************************
    Import Area
    ************************************************************************'''

import irclib           # Does all the interacting with the server stuff and gives nice and tidy objects (3rd party)
import py_bot_init      # Does the initialising Stuff (read config, load wordlists to memory etc)
import py_bot_parse     # Does the parsing of normal public channel messages and private messages to the bot

#irclib.DEBUG = True


''' ***************************************************************************
    Event Handler Area
    ************************************************************************'''

# Generic echo handler ( space added )
# This is used to output some initial information from the server
def handleEcho ( connection, event ):

   print
   print ' '.join ( event.arguments() )


# Generic echo handler ( no space added )
def handleNoSpace ( connection, event ):

   print ' '.join ( event.arguments() )


# Handle private notices
def handlePrivNotice ( connection, event ):

   if event.source():
      print ':: ' + event.source() + ' ->' + event.arguments() [ 0 ]
   else:
      print event.arguments() [ 0 ]


# Handle channel joins
def handleJoin ( connection, event ):

   # The source needs to be split into just the name
   # It comes in the format nickname!user@host
   print event.source().split ( '!' ) [ 0 ] + ' has joined ' + event.target()


# Handle Invitations from other users
def handleInvite ( connection, event ):

   connection.join ( event.arguments() [ 0 ] )




# Handle Private messages
def handlePrivMessage ( connection, event ):
  print event.source().split ( '!' ) [ 0 ] + ': ' + event.arguments() [ 0 ]

  # Respond to a "hello" message
   #if event.arguments() [ 0 ].lower().find ( 'hello' ) == 0:
      #connection.privmsg ( event.source().split ( '!' ) [ 0 ], 'Hello.' )
   #else:
      #connection.privmsg ( event.source().split ( '!' ) [ 0 ], 'Bla: ' + event.target() + '> ' + event.source().split ( '!' ) [ 0 ] + ': ' + event.arguments() [ 0 ] )

# Handle Public messages
def handlePubMessage ( connection, event ):

   #print event.target() + '> ' + event.source().split ( '!' ) [ 0 ] + ': ' + event.arguments() [ 0 ]
   connection.privmsg ( channel, 'Bla: ' + event.target() + '> ' + event.source() + ': ' + event.arguments() [ 0 ] )





# Handle changed channel Topic
def handleTopic ( connection, event ):

   print event.source().split ( '!' ) [ 0 ] + ' has set the topic to "' + event.arguments() [ 0 ] + '"'


# Handle changed channel or user mode
def handleMode ( connection, event ):

   # Channel mode
   if len ( event.arguments() ) < 2:
      print event.source().split ( '!' ) [ 0 ] + ' has altered the channel\'s mode: ' + event.arguments() [ 0 ]

   # User mode
   else:
      print event.source().split ( '!' ) [ 0 ] + ' has altered ' + event.arguments() [ 1 ] + '\'s mode: ' + event.arguments() [ 0 ]


# Handle user leaving channel
def handlePart ( connection, event ):

   print event.source().split ( '!' ) [ 0 ] + ' has quit ' + event.target()


# Handle user quitting server
def handleQuit ( connection, event ):

   print event.source().split ( '!' ) [ 0 ] + ' has disconnected: ' + event.arguments() [ 0 ]


# Handle user kicked by authority
def handleKick ( connection, event ):

   print event.arguments() [ 0 ] + ' has been kicked by ' + event.source().split ( '!' ) [ 0 ] + ': ' + event.arguments() [ 1 ]



''' ***************************************************************************
    Initialisation of IRC events Area
    ************************************************************************'''

# Create the IRC object
irc = irclib.IRC()

# Register handlers
irc.add_global_handler ( 'privnotice', handlePrivNotice ) #Private notice
irc.add_global_handler ( 'welcome', handleEcho )          # Welcome message
irc.add_global_handler ( 'yourhost', handleEcho )         # Host message
irc.add_global_handler ( 'created', handleEcho )          # Server creation message
irc.add_global_handler ( 'myinfo', handleEcho )           # "My info" message
irc.add_global_handler ( 'featurelist', handleEcho )      # Server feature list
irc.add_global_handler ( 'luserclient', handleEcho )      # User count
irc.add_global_handler ( 'luserop', handleEcho )          # Operator count
irc.add_global_handler ( 'luserchannels', handleEcho )    # Channel count
irc.add_global_handler ( 'luserme', handleEcho )          # Server client count
irc.add_global_handler ( 'n_local', handleEcho )          # Server client count/maximum
irc.add_global_handler ( 'n_global', handleEcho )         # Network client count/maximum
irc.add_global_handler ( 'luserconns', handleEcho )       # Record client count
irc.add_global_handler ( 'luserunknown', handleEcho )     # Unknown connections
irc.add_global_handler ( 'motdstart', handleEcho )        # Message of the day ( start )
irc.add_global_handler ( 'motd', handleNoSpace )          # Message of the day
irc.add_global_handler ( 'edofmotd', handleEcho )         # Message of the day ( end )
irc.add_global_handler ( 'join', handleJoin )             # Channel join
irc.add_global_handler ( 'namreply', handleNoSpace )      # Channel name list
irc.add_global_handler ( 'endofnames', handleNoSpace )    # Channel name list ( end )
irc.add_global_handler ( 'invite', handleInvite )         # Invite
irc.add_global_handler ( 'privmsg', handlePrivMessage )   # Private messages
irc.add_global_handler ( 'pubmsg', handlePubMessage )     # Public messages
irc.add_global_handler ( 'topic', handleTopic )           # Channel topic change
irc.add_global_handler ( 'mode', handleMode )             # Channel or user mode changed
irc.add_global_handler ( 'part', handlePart )             # User leaves Channel
irc.add_global_handler ( 'quit', handleQuit )             # User quits Server
irc.add_global_handler ( 'kick', handleKick )             # User is kicked by authority

'''
########################################################################################
# Full list of all handlers
#
#
216 -> statskline
217 -> statsqline
214 -> statsnline
215 -> statsiline
212 -> statscommands
213 -> statscline
210 -> tracereconnect
211 -> statslinkinfo
218 -> statsyline
219 -> endofstats
491 -> nooperhost
492 -> noservicehost
407 -> toomanytargets
406 -> wasnosuchnick
346 -> invitelist
347 -> endofinvitelist
403 -> nosuchchannel
341 -> inviting
342 -> summoning
348 -> exceptlist
349 -> endofexceptlist
409 -> noorigin
263 -> tryagain
262 -> endoftrace
261 -> tracelog
266 -> n_global
265 -> n_local
442 -> notonchannel
423 -> noadmininfo
422 -> nomotd
424 -> fileerror
414 -> wildtoplevel
437 -> unavailresource
411 -> norecipient
412 -> notexttosend
413 -> notoplevel
371 -> info
373 -> infostart
372 -> motd
375 -> motdstart
374 -> endofinfo
377 -> motd2
376 -> endofmotd
319 -> whoischannels
318 -> endofwhois
313 -> whoisoperator
312 -> whoisserver
311 -> whoisuser
317 -> whoisidle
316 -> whoischanop
315 -> endofwho
314 -> whowasuser
393 -> users
392 -> usersstart
391 -> time
395 -> nousers
394 -> endofusers
443 -> useronchannel
368 -> endofbanlist
369 -> endofwhowas
366 -> endofnames
367 -> banlist
364 -> links
365 -> endoflinks
362 -> closing
363 -> closeend
361 -> killdone
300 -> none
301 -> away
302 -> userhost
303 -> ison
305 -> unaway
306 -> nowaway
444 -> nologin
244 -> statshline
382 -> rehashing
241 -> statslline
445 -> summondisabled
243 -> statsoline
242 -> statsuptime
381 -> youreoper
436 -> nickcollision
384 -> myportis
432 -> erroneusnickname
433 -> nicknameinuse
431 -> nonicknamegiven
451 -> notregistered
331 -> notopic
333 -> topicinfo
332 -> topic
258 -> adminloc2
259 -> adminemail
252 -> luserop
253 -> luserunknown
250 -> luserconns
251 -> luserclient
256 -> adminme
257 -> adminloc1
254 -> luserchannels
255 -> luserme
405 -> toomanychannels
404 -> cannotsendtochan
502 -> usersdontmatch
402 -> nosuchserver
401 -> nosuchnick
465 -> yourebannedcreep
464 -> passwdmismatch
467 -> keyset
466 -> youwillbebanned
461 -> needmoreparams
463 -> nopermforhost
462 -> alreadyregistered
221 -> umodeis
446 -> usersdisabled
501 -> umodeunknownflag
234 -> servlist
235 -> servlistend
231 -> serviceinfo
232 -> endofservices
233 -> service
441 -> usernotinchannel
322 -> list
323 -> listend
321 -> liststart
324 -> channelmodeis
476 -> badchanmask
329 -> channelcreate
477 -> nochanmodes
201 -> traceconnecting
200 -> tracelink
203 -> traceunknown
202 -> tracehandshake
205 -> traceuser
204 -> traceoperator
207 -> traceservice
206 -> traceserver
209 -> traceclass
208 -> tracenewtype
475 -> badchannelkey
003 -> created
002 -> yourhost
001 -> welcome
005 -> featurelist
004 -> myinfo
474 -> bannedfromchan
485 -> uniqopprivsneeded
484 -> restricted
483 -> cantkillserver
482 -> chanoprivsneeded
481 -> noprivileges
472 -> unknownmode
473 -> inviteonlychan
471 -> channelisfull
353 -> namreply
352 -> whoreply
351 -> version
421 -> unknowncommand
478 -> banlistfull


#
# Additional events
#

dcc_connect
dcc_disconnect
dccmsg
disconnect
ctcp
ctcpreply
error
join
kick
mode
part
ping
privmsg
privnotice
pubmsg
pubnotice
quit

########################################################################################
'''


''' ***************************************************************************
    Main Program
    ************************************************************************'''

# Connect to the network
server = irc.server()
server.connect ( network, port, nick, ircname = name )
server.join ( channel )

# Run an infinite loop (& listen for events)
irc.process_forever()