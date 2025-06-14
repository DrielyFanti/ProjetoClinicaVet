log_level        :info
log_location     STDOUT
chef_server_url  'https://api.opscode.com/organizations/your-org'
validation_client_name 'your-org-validator'
validation_key   '/etc/chef/your-org-validator.pem'
client_key       '/etc/chef/client.pem'
cookbook_path    ['/var/chef/cookbooks']
role_path        ['/var/chef/roles']
data_bag_path    ['/var/chef/data_bags']
environment_path ['/var/chef/environments']
file_backup_path '/var/chef/backup'
file_cache_path  '/var/chef/cache'
cache_options({ :path => '/var/chef/cache/checksums', :skip_expires => true }) 