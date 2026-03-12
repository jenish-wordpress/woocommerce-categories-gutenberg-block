import { __ } from "@wordpress/i18n";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import {
	PanelBody,
	SelectControl,
	ToggleControl,
	RangeControl,
	Placeholder,
	Spinner,
} from "@wordpress/components";
import { useSelect } from "@wordpress/data";
import { store as coreStore } from "@wordpress/core-data";
import "./editor.scss";

const TEXTDOMAIN = "category-display-for-woocommerce";

/**
 * Single category card — mirrors the frontend HTML structure.
 */
function CategoryCard( { category, showCount } ) {
	const imageUrl =
		category?._embedded?.["wp:featuredmedia"]?.[0]?.source_url || null;

	return (
		<div className="cat-display-item">
			<div className="cat-display-image">
				{ imageUrl ? (
					<img src={ imageUrl } alt={ category.name } />
				) : (
					<div className="cat-display-placeholder-img">
						<span className="dashicons dashicons-format-image"></span>
					</div>
				) }
			</div>
			<div className="cat-display-content">
				<h4 className="cat-display-title">
					{ category.name || __( "Category", TEXTDOMAIN ) }
				</h4>
				{ showCount && (
					<span className="cat-display-count">
						{ category.count === 1
							? sprintf( __( "%s Product", TEXTDOMAIN ), category.count )
							: sprintf( __( "%s Products", TEXTDOMAIN ), category.count || 0 ) }
					</span>
				) }
			</div>
		</div>
	);
}

export default function Edit( { attributes, setAttributes } ) {
	const {
		layout,
		columns,
		limit,
		showAll,
		orderBy,
		order,
		showCount,
		hideEmpty,
	} = attributes;

	const blockProps = useBlockProps( {
		className: `cat-display-block cat-display-layout-${ layout } cat-display-cols-${ columns }`,
	} );

	const { categories, isLoading } = useSelect(
		( select ) => {
			const query = {
				per_page: showAll ? 100 : limit,
				orderby: orderBy === "term_id" ? "id" : orderBy,
				order: order.toLowerCase(),
				hide_empty: hideEmpty,
				_embed: true,
			};

			const data = select( coreStore ).getEntityRecords(
				"taxonomy",
				"product_cat",
				query
			);

			const loading = select( coreStore ).isResolving(
				"getEntityRecords",
				[ "taxonomy", "product_cat", query ]
			);

			return { categories: data || [], isLoading: loading };
		},
		[ limit, showAll, orderBy, order, hideEmpty ]
	);

	const displayCategories = showAll ? categories : categories.slice( 0, limit );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( "Layout Settings", TEXTDOMAIN ) } initialOpen={ true }>
					<SelectControl
						label={ __( "Display Layout", TEXTDOMAIN ) }
						value={ layout }
						options={ [
							{ label: __( "Grid", TEXTDOMAIN ), value: "grid" },
							{ label: __( "Slider", TEXTDOMAIN ), value: "slider" },
						] }
						onChange={ ( val ) => setAttributes( { layout: val } ) }
						help={ __( "Choose how to display the categories", TEXTDOMAIN ) }
					/>
					<RangeControl
						label={ __( "Columns", TEXTDOMAIN ) }
						value={ columns }
						min={ 1 }
						max={ 6 }
						onChange={ ( val ) => setAttributes( { columns: val } ) }
						help={
							layout === "slider"
								? __( "Slides visible at once", TEXTDOMAIN )
								: __( "Columns in grid", TEXTDOMAIN )
						}
					/>
				</PanelBody>

				<PanelBody title={ __( "Category Settings", TEXTDOMAIN ) } initialOpen={ true }>
					<ToggleControl
						label={ __( "Show All Categories", TEXTDOMAIN ) }
						checked={ showAll }
						onChange={ ( val ) => setAttributes( { showAll: val } ) }
						help={ __( "Display all available categories", TEXTDOMAIN ) }
					/>
					{ ! showAll && (
						<RangeControl
							label={ __( "Number of Categories", TEXTDOMAIN ) }
							value={ limit }
							min={ 1 }
							max={ 50 }
							onChange={ ( val ) => setAttributes( { limit: val } ) }
						/>
					) }
					<SelectControl
						label={ __( "Order By", TEXTDOMAIN ) }
						value={ orderBy }
						options={ [
							{ label: __( "Name", TEXTDOMAIN ), value: "name" },
							{ label: __( "Count", TEXTDOMAIN ), value: "count" },
							{ label: __( "ID", TEXTDOMAIN ), value: "term_id" },
							{ label: __( "Slug", TEXTDOMAIN ), value: "slug" },
						] }
						onChange={ ( val ) => setAttributes( { orderBy: val } ) }
					/>
					<SelectControl
						label={ __( "Order", TEXTDOMAIN ) }
						value={ order }
						options={ [
							{ label: __( "Ascending (A–Z)", TEXTDOMAIN ), value: "ASC" },
							{ label: __( "Descending (Z–A)", TEXTDOMAIN ), value: "DESC" },
						] }
						onChange={ ( val ) => setAttributes( { order: val } ) }
					/>
					<ToggleControl
						label={ __( "Show Product Count", TEXTDOMAIN ) }
						checked={ showCount }
						onChange={ ( val ) => setAttributes( { showCount: val } ) }
						help={ __( "Display number of products per category", TEXTDOMAIN ) }
					/>
					<ToggleControl
						label={ __( "Hide Empty Categories", TEXTDOMAIN ) }
						checked={ hideEmpty }
						onChange={ ( val ) => setAttributes( { hideEmpty: val } ) }
						help={ __( "Hide categories with no products", TEXTDOMAIN ) }
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				{ isLoading && (
					<div className="cat-display-editor-loading">
						<Spinner />
						<p>{ __( "Loading categories…", TEXTDOMAIN ) }</p>
					</div>
				) }

				{ ! isLoading && displayCategories.length === 0 && (
					<Placeholder
						icon="grid-view"
						label={ __( "Category Display for WooCommerce", TEXTDOMAIN ) }
						instructions={ __(
							"No product categories found. Add some categories in WooCommerce to see a preview here.",
							TEXTDOMAIN
						) }
					/>
				) }

				{ ! isLoading && displayCategories.length > 0 && layout === "grid" && (
					<div className="cat-display-grid">
						{ displayCategories.map( ( cat ) => (
							<CategoryCard key={ cat.id } category={ cat } showCount={ showCount } />
						) ) }
					</div>
				) }

				{ ! isLoading && displayCategories.length > 0 && layout === "slider" && (
					<div className="cat-display-slider-preview">
						{ displayCategories.slice( 0, columns ).map( ( cat ) => (
							<CategoryCard key={ cat.id } category={ cat } showCount={ showCount } />
						) ) }
						{ displayCategories.length > columns && (
							<div className="cat-display-slider-more">
								+{ displayCategories.length - columns }{ " " }
								{ __( "more", TEXTDOMAIN ) }
							</div>
						) }
					</div>
				) }
			</div>
		</>
	);
}
