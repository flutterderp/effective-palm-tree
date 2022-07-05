Rebuild the LaunchServices file and refresh Finder to remove duplicate versions of apps from “Open With”.

1. `/System/Library/Frameworks/CoreServices.framework/Frameworks/LaunchServices.framework/Support/lsregister -kill -r -domain local -domain system -domain user`
2. `killall Finder`