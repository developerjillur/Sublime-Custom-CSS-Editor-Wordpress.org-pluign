<?php

defined('ABSPATH') or die("Restricted access!");


function sublimecsse_render_submenu_page() {

	// Variables
    $options = get_option( 'sublimecsse_settings' );
    $content = isset( $options['sublimecsse-content'] ) && ! empty( $options['sublimecsse-content'] ) ? $options['sublimecsse-content'] : '/* Write Your CSS*/';

	// Settings update message
	if ( isset( $_GET['settings-updated'] ) ) :
		?>
			<div id="message" class="updated notice is-dismissible">
				<p>
					<?php _e( 'Your Custom Styles was sucessfully updated.', 'sublimecsse' ); ?>
				</p>
			</div>
		<?php
	endif;

	// Page
	?>
    <div class="wrap">
        <h2 class="title_and_hint">
            <?php _e( 'Sublime Custom CSS Editor', 'sublimecsse' ); ?>
            <br/>
            <span>
                <?php _e( 'Press <code>Ctrl+Space</code> to hint/autocompletion.', 'sublimecsse' ); ?>
            <span/>
        </h2>
		<form name="sublimecsse-form" action="options.php" method="post" enctype="multipart/form-data">
			<?php settings_fields( 'sublimecsse_settings_group' ); ?>

			<!-- Editor form -->
			<div id="container" class="edditor_container">
				<textarea name="sublimecsse_settings[sublimecsse-content]" id="code" ><?php echo esc_attr( $content ); ?></textarea>
				<?php submit_button( __( 'Save Custom Styles', 'sublimecsse' ), 'primary', 'submit', true ); ?>
            </div>
			<!-- End Editor form -->
			<!-- script -->
			<script>
			  var value = "// The bindings defined specifically in the Sublime Text mode\nvar bindings = {\n";
			  var map = CodeMirror.keyMap.sublime;
			  for (var key in map) {
			    var val = map[key];
			    if (key != "fallthrough" && val != "..." && (!/find/.test(val) || /findUnder/.test(val)))
			      value += "  \"" + key + "\": \"" + val + "\",\n";
			  }
			  value += "}\n\n// The implementation of joinLines\n";
			  value += CodeMirror.commands.joinLines.toString().replace(/^function\s*\(/, "function joinLines(").replace(/\n  /g, "\n") + "\n";
			  
			  var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
			    lineNumbers: true,
			    viewportMargin: Infinity,
			    mode: "css",
			    keyMap: "sublime",
			    autoCloseBrackets: true,
			    matchBrackets: true,
			    styleActiveLine: true,
			    showCursorWhenSelecting: true,
			    theme: "monokai",
			    tabSize: 2,
			    extraKeys: {"Ctrl-Space": "autocomplete"},
			    closeCharacters: /[\s()\[\]{};:>,]/,

			  });
			</script>

		</form>
	   </div>
	<?php
}