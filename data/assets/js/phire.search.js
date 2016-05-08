/**
 * Search Module Scripts for Phire CMS 2
 */

jax(document).ready(function(){
    if (jax('#searches-form')[0] != undefined) {
        jax('#checkall').click(function(){
            if (this.checked) {
                jax('#searches-form').checkAll(this.value);
            } else {
                jax('#searches-form').uncheckAll(this.value);
            }
        });
        jax('#searches-form').submit(function(){
            return jax('#searches-form').checkValidate('checkbox', true);
        });
    }
});