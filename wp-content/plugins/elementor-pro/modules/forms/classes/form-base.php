<?php
namespace ElementorPro\Modules\Forms\Classes;

use Elementor\Widget_Base;
use ElementorPro\Modules\Forms\Module;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Form_Base extends Widget_Base {

	public function get_name() {}

	public function get_title() {}

	public function get_icon() {}

	public function get_categories() {
		return [ 'pro-elements' ];
	}

	public function on_export( $element ) {
		/** @var \ElementorPro\Modules\Forms\Classes\Action_Base[] $actions */
		$actions = Module::instance()->get_form_actions();

		foreach ( $actions as $action ) {
			$element = $action->on_export( $element );
		}

		return $element;
	}

	public static function get_button_sizes() {
		return [
			'xs' => __( 'Extra Small', 'elementor-pro' ),
			'sm' => __( 'Small', 'elementor-pro' ),
			'md' => __( 'Medium', 'elementor-pro' ),
			'lg' => __( 'Large', 'elementor-pro' ),
			'xl' => __( 'Extra Large', 'elementor-pro' ),
		];
	}

	protected function make_textarea_field( $item, $item_index ) {
		$this->add_render_attribute( 'textarea' . $item_index, [
			'class' => [
				'elementor-field-textual',
				'elementor-field',
				esc_attr( $item['css_classes'] ),
				'elementor-size-' . $item['input_size'],
			],
			'name' => $this->get_attribute_name( $item ),
			'id' => $this->get_attribute_id( $item ),
			'rows' => $item['rows'],
		] );

		if ( $item['placeholder'] ) {
			$this->add_render_attribute( 'textarea' . $item_index , 'placeholder', $item['placeholder'] );
		}

		if ( $item['required'] ) {
			$this->add_render_attribute( 'textarea' . $item_index , 'required', true );
			$this->add_render_attribute( 'textarea' . $item_index , 'aria-required', 'true' );
		}

		return '<textarea ' . $this->get_render_attribute_string( 'textarea' . $item_index ) . '></textarea>';
	}

	protected function make_select_field( $item, $i ) {
		$this->add_render_attribute(
			[
				'select-wrapper' . $i => [
					'class' => [
						'elementor-field',
						'elementor-select-wrapper',
						esc_attr( $item['css_classes'] ),
					],
				],
				'select' . $i => [
					'name' => $this->get_attribute_name( $item ),
					'id' => $this->get_attribute_id( $item ),
					'class' => [
						'elementor-field-textual',
						'elementor-size-' . $item['input_size'],
					],
				],
			]
		);

		if ( $item['required'] ) {
			$this->add_render_attribute( 'select' . $i , 'required', true );
			$this->add_render_attribute( 'select' . $i , 'aria-required', 'true' );
		}

		$options = preg_split( "/\\r\\n|\\r|\\n/", $item['field_options'] );

		if ( ! $options ) {
			return '';
		}

		ob_start();
		?>
		<div <?php echo $this->get_render_attribute_string( 'select-wrapper' . $i ); ?>>
			<select <?php echo $this->get_render_attribute_string( 'select' . $i ); ?>>
				<?php
				foreach ( $options as $option ) : ?>
					<option value="<?php echo esc_attr( $option ); ?>"><?php echo $option; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<?php

		return ob_get_clean();
	}

	protected function make_radio_checkbox_field( $item, $item_index, $type ) {
		$options = preg_split( "/\\r\\n|\\r|\\n/", $item['field_options'] );
		$html = '';
		if ( $options ) {
			$html .= '<div class="elementor-field-subgroup ' . esc_attr( $item['css_classes'] ) . ' ' . $item['inline_list'] . '">';
			foreach ( $options as $key => $option ) {
				$html .= '<span class="elementor-field-option"><input type="' . $type . '"
							value="' . esc_attr( $option ) . '"
							id="' . $this->get_attribute_id( $item_index ) . '-' . $key . '"
							name="' . $this->get_attribute_name( $item ) . ( ( 'checkbox' === $type && count( $options ) > 1 ) ? '[]"' : '"' ) .
							( ( $item['required'] && 'radio' === $type ) ? ' required aria-required="true"' : '' ) . '>
							<label for="' . $this->get_attribute_id( $item ) . '-' . $key . '">' . $option . '</label></span>';
			}
			$html .= '</div>';
		}
		return $html;
	}

	protected function form_fields_render_attributes( $i, $instance, $item ) {
		$this->add_render_attribute(
			[
				'field-group' . $i => [
					'class' => [
						'elementor-field-type-' . $item['field_type'],
						'elementor-field-group',
						'elementor-column',
					],
				],
				'input' . $i => [
					'type' => $item['field_type'],
					'name' => $this->get_attribute_name( $item ),
					'id' => $this->get_attribute_id( $item ),
					'class' => [
						'elementor-field',
						'elementor-size-' . $item['input_size'],
						empty( $item['css_classes'] ) ? '' : esc_attr( $item['css_classes'] ),
					],
				],
				'label' . $i => [
					'for' => $this->get_attribute_id( $i ),
					'class' => 'elementor-field-label',
				],
			]
		);

		if ( empty( $item['width'] ) ) {
			$item['width'] = '100';
		}

		$this->add_render_attribute( 'field-group' . $i, 'class', 'elementor-col-' . $item['width'] );

		if ( ! empty( $item['width_tablet'] ) ) {
			$this->add_render_attribute( 'field-group' . $i , 'class' , 'elementor-md-' . $item['width_tablet'] );
		}

		if ( ! empty( $item['width_mobile'] ) ) {
			$this->add_render_attribute( 'field-group' . $i , 'class' , 'elementor-sm-' . $item['width_mobile'] );
		}

		if ( ! empty( $item['placeholder'] ) ) {
			$this->add_render_attribute( 'input' . $i , 'placeholder', $item['placeholder'] );
		}

		if ( ! $instance['show_labels'] ) {
			$this->add_render_attribute( 'label' . $i, 'class', 'elementor-screen-only' );
		}

		if ( ! empty( $item['required'] ) ) {
			$class = 'elementor-field-required';
			if ( ! empty( $instance['mark_required'] ) ) {
				$class .= ' elementor-mark-required';
			}
			$this->add_render_attribute( 'field-group' . $i , 'class', $class )
				 ->add_render_attribute( 'input' . $i , 'required', true )
				 ->add_render_attribute( 'input' . $i , 'aria-required', 'true' );
		}
	}

	public function render_plain_content() {}

	protected function get_attribute_name( $item ) {
		return "form_fields[{$item['_id']}]";
	}

	protected function get_attribute_id( $item ) {
		return 'form-field-' . $item['_id'];
	}
}
