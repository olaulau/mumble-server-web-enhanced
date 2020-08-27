# mumble-server-web-enhanced

A Mumble web viewer, based on the old [mumble-server-web package](http://packages.ubuntu.com/precise-updates/mumble-server-web).

![old-screenshot](/img/screenshot0.png?raw=true) ===>  ![current-screenshot](/img/screenshot1.png?raw=true)

See [INSTALL.md](https://github.com/olaulau/mumble-server-web-enhanced/blob/master/INSTALL.md) for detailled installation instructions.

### Requirements
- PHP (7.4 tested)
- PHP module zeroconf ice (php-zeroc-ice package under Debian / Ubuntu)

### Features
- PHP based : no django requirement
- pull and refresh data's over AJAX, thanks to [JsTree](http://www.jstree.com/) usage
- status icons as in mumble client
- URL parameters (decoration=0 , scale=0.75) to easy site integration
- reduced mode, which hides empty channels

Current version is nearly final, basic features are all here.
### Futures enhancements
- remember closed nodes (so refresh will be nicer)
- display more info about players (hover layer)
- display server info (root node hover layer)
- add footer link to sources
- add small buttons to refresh and open a full viewer

### Used resources
- [mumble client icons](https://github.com/mumble-voip/mumble/tree/master/icons) ([3-clause BSD license](https://github.com/mumble-voip/mumble/blob/master/LICENSE))
