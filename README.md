# LDAP Server


# Source
https://blog.ruanbekker.com/blog/2022/03/20/run-openldap-with-a-ui-on-docker/


Boot


Boot the stack with docker-compose:

1

	

docker-compose up -d

You can access OpenLDAP-UI on port 18080 and the admin password will be admin. You will have admin access to create users.
Verify Users

Access the openldap container:

1

	

docker-compose exec openldap bash

You can use ldapsearch to verify our user:

1

	

ldapsearch -x -h openldap -D "uid=ruan,ou=people,dc=example,dc=org" -b "ou=people,dc=example,dc=org" -w "$PASSWORD" -s base 'uid=ruan'

Or we can use ldapwhoami:

1

	

ldapwhoami -vvv -h ldap://openldap:389 -p 389 -D 'uid=ruan,ou=people,dc=example,dc=org' -x -w "$PASSWORD"

Which will provide a output with something like:

1
2
3

	

ldap_initialize( <DEFAULT> )
dn:uid=ruan,ou=people,dc=example,dc=org
Result: Success (0)

