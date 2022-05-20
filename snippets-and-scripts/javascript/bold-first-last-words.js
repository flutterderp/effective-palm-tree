let boldFirst = document.getElementsByClassName('bold__first-word'),
    boldLast  = document.getElementsByClassName('bold__last-word')

for(i=0; i < boldFirst.length; ++i) {
  boldFirstWord(boldFirst[i])
}

for(i=0; i < boldLast.length; ++i) {
  boldLastWord(boldLast[i])
}

function boldFirstWord(el) {
  el.innerHTML = el.innerHTML.replace(/(\w+)/, function(s, c) { return s.replace(c, '<b>' + c + '</b>') })
}

function boldLastWord(el) {
  el.innerHTML = el.innerHTML.replace(/(\w+)?(?=\W*(\<\/p|div\>)?$)/, function(s, c) { return s.replace(c, '<b>' + c + '</b>') })
}

/**
 * Reference stack exchange answers
 * @link https://stackoverflow.com/a/21324495/1896325
 * @link https://stackoverflow.com/a/61519055/1896325
 */
