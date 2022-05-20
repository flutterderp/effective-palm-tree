
## Example usage of squoosh CLI
```sh
# install squoosh
npm i -g @squoosh/cli

# example usage
# squoosh gets hung up on DS files…
> find . -name '.DS_Store' -type f -delete

> squoosh-cli --mozjpeg '{quality:65}' ./ -d ./squooshed                          
```