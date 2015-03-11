VAGRANTFILE_API_VERSION = "2"


Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

	ui = Vagrant::UI::Colored.new

	# This is the path of the file containing the SSH private key. It's used by
	# Vagrant to connect to your VM. This file must be at the same path level with
	# this file.
	config.ssh.private_key_path = "ssh_key.priv"
	config.ssh.pty= true

	# This is the name of the box used by Vagrant.
	config.vm.box = "Solerni2DevBox"

	# The URL where Vagrant will download the box.
	config.vm.box_url ="http://10.192.228.115/vagrant/solerni2_dev_box.box"

	# The VM will bring up with a bridged adapter, and use the Orange DHCP server
	# to obtain an IP.
	config.vm.network "public_network", :mac => "XXXXXXXXXXXX"

	# The local port 10080 on the host machine will be fowarded to the port 80 of
	# the guest VM.
	config.vm.network :forwarded_port, host: 10080, guest: 80

	# The local port 13306 on the host machine will be fowarded to the port 3306
	# of the guest VM.
	config.vm.network :forwarded_port, host: 13306, guest: 3306

	# Configuration for the VirtualBox provider
	config.vm.provider "virtualbox" do |v|
		# number of CPU cores used by the VirtualBox VM
		v.cpus = 1
		# Host CPU execution cap used by the VirtualBox VM
		v.customize ["modifyvm", :id, "--cpuexecutioncap", "100"]
		# memory in MB used by the VirtualBox VM
		v.memory = 1024
		# name the VirtualBox VM
		v.name = "Solerni2 Dev"

	end

	# This script will be executing when the VM will be creating from a vagrant 
	# box. If the VM already exists, the script is ignored.
	config.vm.provision "shell", inline: "/root/scripts/vagrant/provision_vm.sh", privileged: true

	config.vm.synced_folder "vagrant/override", "/opt/solerni/solerni/dev/override"
	config.vm.synced_folder "vagrant/moodle", "/opt/solerni/solerni/dev/moodle", type: "rsync"
	config.vm.synced_folder "vagrant/moodledata", "/opt/solerni/solerni/data"
	config.vm.synced_folder "vagrant/solerni", "/opt/solerni/solerni/dev/solerni", type: "rsync"
	config.vm.synced_folder "vagrant/system/root/backups", "/root/backups"
	config.vm.synced_folder "vagrant/system/mnt/samba", "/mnt/samba"

end
