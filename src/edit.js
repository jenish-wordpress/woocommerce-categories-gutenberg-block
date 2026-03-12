import { __ } from "@wordpress/i18n";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import {
	PanelBody,
	SelectControl,
	ToggleControl,
	RangeControl,
} from "@wordpress/components";
import "./editor.scss";

export default function Edit({ attributes, setAttributes }) {
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

	const blockProps = useBlockProps({
		className: "wc-category-display-editor",
	});

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={__("Layout Settings", "wc-category-display")}
					initialOpen={true}
				>
					<SelectControl
						label={__("Display Layout", "wc-category-display")}
						value={layout}
						options={[
							{ label: __("Grid", "wc-category-display"), value: "grid" },
							{ label: __("Slider", "wc-category-display"), value: "slider" },
						]}
						onChange={(val) => setAttributes({ layout: val })}
						help={__(
							"Choose how to display the categories",
							"wc-category-display",
						)}
					/>

					<RangeControl
						label={__("Columns", "wc-category-display")}
						value={columns}
						min={1}
						max={6}
						onChange={(val) => setAttributes({ columns: val })}
						help={
							layout === "slider"
								? __("Number of slides visible at once", "wc-category-display")
								: __("Number of columns in grid", "wc-category-display")
						}
					/>
				</PanelBody>

				<PanelBody
					title={__("Category Settings", "wc-category-display")}
					initialOpen={true}
				>
					<ToggleControl
						label={__("Show All Categories", "wc-category-display")}
						checked={showAll}
						onChange={(val) => setAttributes({ showAll: val })}
						help={__("Display all available categories", "wc-category-display")}
					/>

					{!showAll && (
						<RangeControl
							label={__("Number of Categories", "wc-category-display")}
							value={limit}
							min={1}
							max={50}
							onChange={(val) => setAttributes({ limit: val })}
						/>
					)}

					<SelectControl
						label={__("Order By", "wc-category-display")}
						value={orderBy}
						options={[
							{ label: __("Name", "wc-category-display"), value: "name" },
							{ label: __("Count", "wc-category-display"), value: "count" },
							{ label: __("ID", "wc-category-display"), value: "term_id" },
							{ label: __("Slug", "wc-category-display"), value: "slug" },
						]}
						onChange={(val) => setAttributes({ orderBy: val })}
					/>

					<SelectControl
						label={__("Order", "wc-category-display")}
						value={order}
						options={[
							{
								label: __("Ascending (A-Z)", "wc-category-display"),
								value: "ASC",
							},
							{
								label: __("Descending (Z-A)", "wc-category-display"),
								value: "DESC",
							},
						]}
						onChange={(val) => setAttributes({ order: val })}
					/>

					<ToggleControl
						label={__("Show Product Count", "wc-category-display")}
						checked={showCount}
						onChange={(val) => setAttributes({ showCount: val })}
						help={__(
							"Display number of products in each category",
							"wc-category-display",
						)}
					/>

					<ToggleControl
						label={__("Hide Empty Categories", "wc-category-display")}
						checked={hideEmpty}
						onChange={(val) => setAttributes({ hideEmpty: val })}
						help={__("Hide categories with no products", "wc-category-display")}
					/>
				</PanelBody>
			</InspectorControls>

			<div {...blockProps}>
				<div className="wc-category-preview">
					<div className="preview-icon">
						<span className="dashicons dashicons-grid-view"></span>
					</div>
					<h3>{__("WooCommerce Category Display", "wc-category-display")}</h3>
					<div className="preview-settings">
						<div className="setting-item">
							<strong>{__("Layout:", "wc-category-display")}</strong>
							<span>
								{layout === "grid"
									? __("Grid", "wc-category-display")
									: __("Slider", "wc-category-display")}
							</span>
						</div>
						<div className="setting-item">
							<strong>{__("Columns:", "wc-category-display")}</strong>
							<span>{columns}</span>
						</div>
						<div className="setting-item">
							<strong>{__("Categories:", "wc-category-display")}</strong>
							<span>{showAll ? __("All", "wc-category-display") : limit}</span>
						</div>
						<div className="setting-item">
							<strong>{__("Order:", "wc-category-display")}</strong>
							<span>
								{orderBy} ({order})
							</span>
						</div>
						{showCount && (
							<div className="setting-item">
								<span className="dashicons dashicons-yes"></span>
								{__("Show Count", "wc-category-display")}
							</div>
						)}
					</div>
					<p className="preview-note">
						{__(
							"Preview will be displayed on the frontend",
							"wc-category-display",
						)}
					</p>
				</div>
			</div>
		</>
	);
}
