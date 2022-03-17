/**
 * Example usage of Signature Pad
 *
 * @link https://github.com/szimek/signature_pad
 *
 * HTML for form field/signature canvas
 * <input type="hidden" name="form_signature">
 * <div class="signature-pad" id="signature-pad"><canvas></canvas></div>
 *
 * Script tag for loading Signature Pad
 * <script src="path/to/js/assets/signature_pad.umd.min.js"></script>
 *
 * Example styles for the signature pad
 * .signature-pad { margin: 20px auto 20px; }
 * .signature-pad canvas { background: #fefefe; border: 1px solid #0a0a0a; filter: drop-shadow(0 0 1px rgba(0,0,0,.25)); }
 */

window.addEventListener('DOMContentLoaded', function() {
  const sigCanvas = document.querySelector('canvas')

  if(sigCanvas !== null) {
    let signaturePad = new SignaturePad(sigCanvas),
        // confirmForm  = document.getElementById('confirm_form'),
        confirmForm  = document.forms.confirm_form,
        clearButton  = document.querySelector('[data-action=clear]'),
        sigfield     = confirmForm.elements.form_signature

    // Clear button
    clearButton.addEventListener('click', function(e)
    {
      e.preventDefault();
      signaturePad.clear();
    })

    // Save button
    confirmForm.addEventListener('submit', function(e) {
      e.preventDefault();

      console.log(confirmForm.elements.action.value)

      if (signaturePad.isEmpty())
      {
        // alert('Please provide signature first.');
        sigfield.value = '';
      }
      else
      {
        sigfield.value = signaturePad.toDataURL();
        // grecaptcha.execute();

        confirmForm.submit();
      }
    })
  }
})
