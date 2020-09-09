# RemoteTopology
### Welcome to RT, it complex solution consisting of PHP site, service for establishing SSH connection, database with competitor and more
### Notes
1. Connecting to virtual machines will be  established through VCSA
2. Connection to network devices will be established through SSH connection to console server
3. Competitors get access to RT over VPN connection
> VPN itself is not implemented as a separate service in RT, but sooner or later we will come to this :)
### Requirements
1. Server (Linux must have😀) with installed `docker` service
2. `VPN` Gateway (I recommend you Cisco AnyConnect)
3. Installed `VCSA` and virtual machines with stands in ready state
4. `Console` server for connect to network devices