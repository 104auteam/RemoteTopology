from flask import Flask, request, jsonify
from flask_restful import Api, Resource, reqparse
from vmware.vapi.vsphere.client import create_vsphere_client
import random
# import asyncio
# import aiohttp
import sys, getopt
import requests
import urllib3

def main(argv):
    # Init state
    app = Flask(__name__)
    api = Api(app)
    api.add_resource(Links, '/get-links')
    api.add_resource(Link, '/get-link')
    api.add_resource(DC, '/get-dc')

    # Run application
    try:
        argv[0]
    except IndexError:
        app.run(debug=False,host='0.0.0.0')
    finally:
        for arg in argv:
            if arg == '-d' or '--debug': 
                app.run(debug=True,host='0.0.0.0')

class Link(Resource):
    def get(self):
        address    = request.args.get('a')
        username   = request.args.get('u')  
        password   = request.args.get('p')  
        datacenter = request.args.get('d') 
        vm         = request.args.get('v')

        # Create connection to VCenter
        try:
            # Disable certification verify
            session = requests.session()
            session.verify = False
            urllib3.disable_warnings(urllib3.exceptions.InsecureRequestWarning)
            # Create connection
            vc = create_vsphere_client(server=address, username=username, password=password, session=session)
        except requests.exceptions.ConnectionError:
            return 'Failed to connect', 404
        # Find DC
        dcSummary = vc.vcenter.Datacenter.list(vc.vcenter.Datacenter.FilterSpec(names={datacenter}))
        vmDatacenters = { dcSummary[0].datacenter, }
        if dcSummary == []: return 'DC was not found', 404

        # Find VM
        vmNames = { vm, }
        vmSummary = vc.vcenter.VM.list(vc.vcenter.VM.FilterSpec(names=vmNames,datacenters=vmDatacenters))
        if vmSummary == []: return 'VM was not found', 404

        vmid = vmSummary[0].vm
        spec = vc.vcenter.vm.console.Tickets.CreateSpec(vc.vcenter.vm.console.Tickets.Type('VMRC'))
        
        ticket = vc.vcenter.vm.console.Tickets.create(vmid, spec).ticket

        info = {
            'address': address,
            'username': username,
            'password': password,
            'datacenter': datacenter,
            'vm': vm,
            'ticket': ticket
        }
        return info, 200



class Links(Resource):

    def get(self):
        address    = request.args.get('a')
        username   = request.args.get('u')  
        password   = request.args.get('p')  
        datacenter = request.args.get('d') 
        vm_list    = request.args.get('v')

        vm_list    = vm_list.split(',');
        # Create connection to VCenter
        try:
            # Disable certification verify
            session = requests.session()
            session.verify = False
            urllib3.disable_warnings(urllib3.exceptions.InsecureRequestWarning)
            # Create connection
            vc = create_vsphere_client(server=address, username=username, password=password, session=session)
        except requests.exceptions.ConnectionError:
            return 'Failed to connect', 404
        # Find DC
        dcSummary = vc.vcenter.Datacenter.list(vc.vcenter.Datacenter.FilterSpec(names={datacenter}))
        vmDatacenters = { dcSummary[0].datacenter, }
        if dcSummary == []: return 'DC was not found', 404

        # Get tickets VM
        info = {}
        for vm in vm_list:
            vmNames = { vm }
            vmSummary = vc.vcenter.VM.list(vc.vcenter.VM.FilterSpec(names=vmNames,datacenters=vmDatacenters))
            if vmSummary == []: info[vm] = 'VM was not found'; continue

            vmid = vmSummary[0].vm
            spec = vc.vcenter.vm.console.Tickets.CreateSpec(vc.vcenter.vm.console.Tickets.Type('VMRC'))
            
            ticket = vc.vcenter.vm.console.Tickets.create(vmid, spec).ticket
            info[vm] = ticket

        return info, 200

class DC(Resource):
    def get(self):
        address    = request.args.get('a')
        username   = request.args.get('u')  
        password   = request.args.get('p')  
        datacenter = request.args.get('d')  
        info = {
            'address': address,
            'username': username,
            'password': password,
            'datacenter': datacenter
        }
        # Create connection to VCenter
        try:
            # Disable certification verify
            session = requests.session()
            session.verify = False
            urllib3.disable_warnings(urllib3.exceptions.InsecureRequestWarning)
            # Create connection
            vc = create_vsphere_client(server=address, username=username, password=password, session=session)
        except requests.exceptions.ConnectionError:
            return 'Failed to connect', 404
        
        dc = vc.vcenter.Datacenter.list()
        out = {}
        i = 1
        for obj in dc:
            out.update( { str(i): obj.name } )
            i +=1
        return out, 200

if __name__ == '__main__':
	main(sys.argv[1:])