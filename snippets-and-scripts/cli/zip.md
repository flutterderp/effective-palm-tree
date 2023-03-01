
# Examples of zipping the current folder using the CLI zip tool

```sh
zip -r ${PWD##*/}.zip ./ -x "*._*" "*.git*" "*.svn*" "*.DS_Store"
```

## Using an external file for the exclusion list

This can be also be saved as an executable `.sh` file (e.g. `create-package.sh`) in a directory you might frequently zip up, like a CMS template.

```sh
zip -r ${PWD##*/}.zip ./ -x@"./exclude.lst"
```

```plaintext
_random-directory/*
create-package.sh
exclude.lst
*._*
*.git*
*.svn*
*.DS_Store
```