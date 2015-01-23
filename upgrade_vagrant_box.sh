#!/bin/bash

# The directory where this script is located
BASE_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"


function upgrade_vagrant_box () {
	vagrant halt
	vagrant destroy
	vagrant box remove Solerni2DevBox
	export http_proxy=http://niceway:3128 && export https_proxy=https://niceway:3128 && export ftp_proxy=http://niceway:3128
	vagrant up
}

function main () {
	upgrade_vagrant_box
	exit 0;
}


main "$@"
