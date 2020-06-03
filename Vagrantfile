Vagrant.configure(2) do |config|
    config.vm.box = "ubuntu/bionic64"
    config.vm.synced_folder ".", "/srv/www"
    config.vm.network "private_network", ip: "192.168.99.100"
    config.vm.provider "virtualbox" do |vb|
          vb.gui = false
          vb.memory = "2048"
          vb.name = "hkr"
    end
    config.vm.provision "shell" do |s|
        s.inline = "/srv/www/provisioning/provision.sh $1"
        s.args = "local"
    end
    config.vm.provision "shell", run: "always", privileged: false do |s|
        s.inline = "/srv/www/provisioning/up.sh"
    end
end
