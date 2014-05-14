VAGRANTFILE_API_VERSION = "2"


Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

	ui = Vagrant::UI::Colored.new

	hostname = ENV['HOSTNAME']
	if hostname.nil?
		ui.say(:error, "==> Error: unable to get the environment variable HOSTNAME")
		ui.say(:info, "    Run the below command:")
		ui.say(:info, "    export HOSTNAME=\`hostname | cut -f1 -d \'.\'\`")
		exit(1)
	end


	# This is the path of the file containing the SSH private key. It's used by
	# Vagrant to connect to your VM. This file must be at the same path level with
	# this file.
	config.ssh.private_key_path = "ssh_key.priv"


	# This is the name of the box used by Vagrant.
	config.vm.box = "SolerniDevBox"

	# The URL where Vagrant will download the box.
	config.vm.box_url ="http://10.192.228.115/vagrant/solerni_dev_box.box"


	# The public name of your VM on the network. This name will be send on the
	# Orange DNS server. So your VM can be resolved by
	# <hostname>-solerni.rd.francetelecom.fr.
	config.vm.hostname = "#{hostname}-solerni"


	# The VM will bring up with a bridged adapter, and use the Orange DHCP server
	# to obtain an IP.
	config.vm.network "public_network"

	# The local port 10080 on the host machine will be fowarded to the port 80 of
	# the guest VM.
	config.vm.network :forwarded_port, host: 10080, guest: 80

	# The local port 13306 on the host machine will be fowarded to the port 3306
	# of the guest VM.
	config.vm.network :forwarded_port, host: 13306, guest: 3306


	# The directory vagrant/SolerniCMS on the host machine will be synced with the
	# directory /usr/share/Solerni/SolerniCMS on the guest VM.
	config.vm.synced_folder "vagrant/SolerniCMS", "/usr/share/Solerni/SolerniCMS"

	# The directory vagrant/SolerniMooc on the host machine will be synced with
	# the directory /usr/share/Solerni/SolerniMooc on the guest VM.
	config.vm.synced_folder "vagrant/SolerniMooc", "/usr/share/Solerni/SolerniMooc"

	# The directory vagrant/log/nginx on the host machine will be synced with the
	# directory /var/log/nginx on the guest VM.
	config.vm.synced_folder "vagrant/log/nginx", "/var/log/nginx/"

end
