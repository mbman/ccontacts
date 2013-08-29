# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|
    config.vm.hostname = "debian-squeeze"
    config.vm.box = "debian-squeeze"
    config.vm.box_url = "https://dl.dropboxusercontent.com/u/13054557/vagrant_boxes/debian-squeeze.box"
 
    config.vm.network :private_network, ip: "192.168.56.101"
    config.ssh.forward_agent = true

    config.vm.synced_folder "./", "/var/www", id: "vagrant-root", :nfs => true
    
    config.vm.provision "chef_solo" do |chef|
        chef.add_recipe "lampapp"
        chef.cookbooks_path = "vagrant/cookbooks"

        chef.json.merge!({
            :lampapp => {
                :name => "hrcontacts",
                :password => "foobar",
                :ip => "192.168.56.101",
                :path => "public",
            },
            :php => {
                :directives => {"date.timezone" => "Europe/Zagreb"}
            }
        })
    end
end
