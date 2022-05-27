<script>
    
    // Define variables
    let input_minlength = 6;
    let input_maxlength = 12;

    // Create and return custom element based on given arguments
    function createCustomElement( tagName, text, className) {

        const customElement = document.createElement( tagName );
        customElement.innerText = text;
        customElement.classList.add( className );

        return customElement;

    }

    function addPatternRestrictionToPasswordField() {

        const PASSWORD_FIELD = document.querySelector( 'input[type="password"]' );

        // Set pattern attribute on password field
        PASSWORD_FIELD.setAttribute( 'pattern', '^\\d{6,12}$' );

    }

    function checkInput() {

        const PINCODE_VALUE = PASSWORD_FIELD.value

        if ( /\D/.test(PINCODE_VALUE) ) {
            
            // Get pincode length
            const PINCODE_LENGTH = PINCODE_VALUE.length;

            // Prevent user from entering more characters as they entered a NON digit
            // (pincode can ONLY contain numbers)
            PASSWORD_FIELD.setAttribute( 'maxlength', PINCODE_LENGTH );

            // Create small element
            const SMALL = document.createElement( 'small' );
            SMALL.classList.add( 'pincode-error' );
            const SMALL_ERROR_TEXT = "Error: Uw pincode mag alleen bestaan uit nummers. Verwijder de karakter (backspace) en typ een nummer in.";

            // Add text to small element
            SMALL.innerText = SMALL_ERROR_TEXT;

            // Retrieve form text (helper text)
            const FORM_TEXT = document.querySelector( '.form-text' );

            // Show error under pincode field
            document.querySelector( '.password-input-group' ).insertBefore( SMALL, FORM_TEXT );
            
            PASSWORD_FIELD.addEventListener( 'keydown', (event) => {

                // Get key code
                const KEY = event.keyCode || event.charCode;

                // If user pressed 'backspace', set maxlength back to its original value of 12
                if ( KEY == 8 ) {
                    
                    PASSWORD_FIELD.setAttribute( 'maxlength', input_maxlength );
                    
                    const PINCODE_ERROR = document.querySelector( '.pincode-error' );         

                    // Remove error
                    if ( PINCODE_ERROR ) PINCODE_ERROR.remove();

                }

            } );
            
        } 

    }

        <?php 
        
        // Only execute following when user is on login page
        if ( is_page( 'inloggen' ) ) {
            ?> 
            
            // Create main heading (h1)
            const MAIN_HEADING = createCustomElement( 'h1', 'Inloggen', 'main-heading' );
            
            // Retrieve first form row on inloggen page
            const FORM_ROW = document.querySelector( '.user-registration-form-row' );

            // Add main heading as next sibling from form row
            FORM_ROW.parentNode.insertBefore( MAIN_HEADING, FORM_ROW );

            // Setup introduction text
            const INTRODUCTION_TEXT = 'Op deze pagina kunt u inloggen om toegang te krijgen tot het \'Oliemonster Portal\'.';

            // Create introduction paragraph
            const INTRODUCTION_PARAGRAPH = createCustomElement( 'p', INTRODUCTION_TEXT, 'introduction-paragraph' );

            // Add introduction paragraph as next sibling from main heading
            FORM_ROW.parentNode.insertBefore( INTRODUCTION_PARAGRAPH, MAIN_HEADING.nextSibling );

            // Create small element
            const SMALL_ELEMENT = createCustomElement( 'small', 'Dit is uw wachtwoord.', 'form-text' );

            // Retrieve the password field on inloggen page
            const PASSWORD_FIELD = document.querySelector( 'input[type="password"]' );
            
            // Add <small> as next sibling from password field
            PASSWORD_FIELD.parentNode.insertBefore( SMALL_ELEMENT, PASSWORD_FIELD.nextSibling );

            // Add minimum and maximum length attributes for pincode
            PASSWORD_FIELD.setAttribute( 'minlength', input_minlength );
            PASSWORD_FIELD.setAttribute( 'maxlength', input_maxlength );
            
            // Set hint for user
            PASSWORD_FIELD.setAttribute( 'title', 'Pincode mag alleen bestaan uit getallen, moet minstens 6 tekens lang zijn en maximaal 12.');

            // Prevent users from entering characters that aren't allowed
            // Pincode is only allowed to exist out of numbers 0 till 9, with a minimum length of 6, and maximum length of 12
            addPatternRestrictionToPasswordField();

            // Check user input on characters that aren't allowed
            PASSWORD_FIELD.addEventListener( 'input', checkInput);

            // Set placeholder for pincode field
            PASSWORD_FIELD.setAttribute( 'placeholder', 'Pincode' );

            // Retrieve the e-mailadres field on inloggen page
            // input name username is here being used because plugin somehow (?) doesn't load in 
            // the corresponding 'email' type and name attr.
            const EMAIL_FIELD = document.querySelector( 'input[name="username"]' );

            // Set placeholder for email field
            EMAIL_FIELD.setAttribute( 'placeholder', 'E-mailadres');

            <?php
        }

        // Only execute following when user is on register page
        if ( is_page( 'registreren' ) ) {

            ?>
            
            // Create main heading (h1)
            const MAIN_HEADING = createCustomElement( 'h1', 'Registreren', 'main-heading' );
            
            // Retrieve first form row on inloggen page
            const FORM_ROW = document.querySelector( '.ur-form-row' );

            // Add main heading as next sibling from form row
            FORM_ROW.parentNode.insertBefore( MAIN_HEADING, FORM_ROW );

            // Setup introduction text
            const INTRODUCTION_TEXT = 'Op deze pagina kunt u zich registeren om toegang te krijgen tot het \'Oliemonster Portal\'.';

            // Create introduction paragraph
            const INTRODUCTION_PARAGRAPH = createCustomElement( 'p', INTRODUCTION_TEXT, 'introduction-paragraph' );

            // Add introduction paragraph as next sibling from main heading
            FORM_ROW.parentNode.insertBefore( INTRODUCTION_PARAGRAPH, MAIN_HEADING.nextSibling );

            // Create small element
            const SMALL_ELEMENT = createCustomElement( 'small', 'De pincode die u opgeeft is uw wachtwoord, onthoudt deze dus goed.', 'form-text' );

            // Retrieve the password field on inloggen page
            const PASSWORD_FIELD = document.querySelector( 'input[type="password"]' );
            
            // Add <small> as next sibling from password field
            PASSWORD_FIELD.parentNode.insertBefore( SMALL_ELEMENT, PASSWORD_FIELD.nextSibling );

            // Add minimum and maximum length attributes for pincode
            PASSWORD_FIELD.setAttribute( 'minlength', input_minlength );
            PASSWORD_FIELD.setAttribute( 'maxlength', input_maxlength );

            // Set hint for user
            PASSWORD_FIELD.setAttribute( 'title', 'Pincode mag alleen bestaan uit getallen, moet minstens 6 tekens lang zijn en maximaal 12.');

            // Prevent users from entering characters that aren't allowed
            // Pincode is only allowed to exist out of numbers 0 till 9, with a minimum length of 6, and maximum length of 12
            addPatternRestrictionToPasswordField();

            // Check user input on characters that aren't allowed
            PASSWORD_FIELD.addEventListener( 'input', checkInput);

            <?php

        }

        ?>
        </script>
</body>
<?php wp_footer(); ?>
</html>