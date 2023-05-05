# LDAP Server


Un container Docker pour découvrir LDAP.

# Todo

- TPs d'installation et de configuration
- TPs de connexion (PHP ou Python)

# Source
https://blog.ruanbekker.com/blog/2022/03/20/run-openldap-with-a-ui-on-docker/


# Boot

Boot the stack with docker-compose:
```bash
docker-compose up -d
```

You can access OpenLDAP-UI on port 18080 and the admin password will be admin. 

http://HOST:18080/setup/

You will have admin access to create users.


# Verify Users

Access the openldap container:
```bash
docker-compose exec openldap bash
```

You can use ldapsearch to verify our user:	

```bash
ldapsearch -x -h openldap -D "uid=ruan,ou=people,dc=example,dc=org" -b "ou=people,dc=example,dc=org" -w "$PASSWORD" -s base 'uid=ruan'
```

Or we can use ldapwhoami:
```bash
ldapwhoami -vvv -h ldap://openldap:389 -p 389 -D 'uid=ruan,ou=people,dc=example,dc=org' -x -w "$PASSWORD"
```

Which will provide a output with something like:
```bash
ldap_initialize( <DEFAULT> )
dn:uid=ruan,ou=people,dc=example,dc=org
Result: Success (0)
```
