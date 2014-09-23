mumble-server-web-enhanced
==========================

A Mumble web viewer, based on the old mumble-server-web package.

![screenshot](/img/screenshot1.png?raw=true)

check the new version [v0.3](https://github.com/olaulau/mumble-server-web-enhanced/tree/v0.3)
features :
- PHP based : no django requirement
- pull and refresh data's over AJAX, thanks to [JsTree](http://www.jstree.com/] usage
- status icons as in mumble client
- URL parameters (decoration=0 , scale=0.75) to easy site integration

Current version is nearly final, basic features are all here.

See [INSTALL.md](https://github.com/olaulau/mumble-server-web-enhanced/blob/master/INSTALL.md) for detailled installation instructions.

Futures enhancements :
- remember closed nodes (so refresh will be nicer)
- display more info about players (hover layer)
- display server info (root node hover layer)
- add footer link to sources
- add small buttons to refresh and open a full viwer