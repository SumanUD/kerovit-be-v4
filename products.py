import pandas as pd

df = pd.read_excel("products.xlsx")
df.columns = df.columns.str.strip()

df['product_code'] = df['product_code'].astype(str).str.strip()
df['range'] = df['range'].astype(str).str.strip()
df['thumbnail_picture'] = df['thumbnail_picture'].astype(str).str.strip()
df['diagram_image_name'] = df['diagram_image_name'].astype(str).str.strip()

df['base_code'] = df['product_code'].str.extract(r'^(.*)-[^-]+$')
df['base_code'] = df['base_code'].fillna(df['product_code'])  # for codes with no hyphen

master_rows = []
variant_rows = []

for base_code, group in df.groupby('base_code'):
    group = group.reset_index(drop=True)
    for i, row in group.iterrows():
        if row['product_code'] == row['base_code']:
            master_rows.append(row)
        elif i == 0:
            master_rows.append(row)
        else:
            variant_rows.append(row.to_dict())

master_df = pd.DataFrame(master_rows).drop_duplicates(subset='product_code').reset_index(drop=True)
variant_df = pd.DataFrame(variant_rows).reset_index(drop=True)

master_df['product_id'] = master_df.index + 1

variant_df = variant_df.merge(master_df[['base_code', 'product_id']], on='base_code', how='left')

variant_df = variant_df[variant_df['product_id'].notna()]
variant_df = variant_df.drop_duplicates(subset='product_code').reset_index(drop=True)

color_map = {
    "GM":  "#545454",  # Gun Metal
    "DGR": "#013220",  # Dark Green
    "CGL": "#D4AF37",  # Chrome Gold
    "CRG": "#B76E79",  # Chrome Rose Gold
    "RG":  "#B76E79",  # Rose Gold
    "GB":  "#0A0A0A",  # Glossy Black
    "CG":  "#ECCAA0",  # Champagne Gold
    "MCF": "#4B3621",  # Matte Coffee
    "MBK": "#2F2F2F",  # Matte Black
    "CP":  "#C0C0C0",  # Chrome Plated
    "DGY": "#A9A9A9",  # Dark Grey
    "LGY": "#D3D3D3",  # Light Grey
    "MW":  "#F5F5F5",  # Matte White
}

def extract_color_code(code):
    parts = code.split('-')
    if len(parts) > 1:
        last = parts[-1]
        second_last = parts[-2] if len(parts) > 2 else ""
        if last in color_map:
            return color_map[last]
        elif second_last in color_map:
            return color_map[second_last]
    return "#000"

master_df['product_color_code'] = master_df['product_code'].apply(extract_color_code)
variant_df['product_color_code'] = variant_df['product_code'].apply(extract_color_code)

master_final = pd.DataFrame({
    'product_id': master_df['product_id'],
    'collection_id': master_df['collection'].astype(str).str.strip(),
    'category_id': master_df['category_name'].astype(str).str.strip(),
    'range_id': master_df['range'].astype(str).str.strip(),
    'product_code': master_df['product_code'].astype(str).str.strip(),
    'product_picture': 'products/' + master_df['thumbnail_picture'].astype(str).str.strip() + '.png',
    'product_title': master_df['product_title'].astype(str).str.strip(),
    'series': None,
    'shape': master_df['shape'].astype(str).str.strip(),
    'spray': master_df['spray'].astype(str).str.strip(),
    'product_description': master_df['product_description'].astype(str).str.strip(),
    'product_color_code': master_df['product_color_code'],
    'product_feature': master_df['product_description'].astype(str).str.strip(),
    'product_installation_service_parts': None,
    'design_files': 'design_files/' + master_df['diagram_image_name'].astype(str).str.strip() + '.pdf',
    'additional_information': master_df['additional_image1'].astype(str).str.strip(),
})

variant_final = pd.DataFrame({
    'product_id': variant_df['product_id'].astype(int),
    'product_code': variant_df['product_code'].astype(str).str.strip(),
    'product_picture': 'products/' + variant_df['thumbnail_picture'].astype(str).str.strip() + '.png',
    'product_title': variant_df['product_title'].astype(str).str.strip(),
    'series': None,
    'shape': variant_df['shape'].astype(str).str.strip(),
    'spray': variant_df['spray'].astype(str).str.strip(),
    'product_description': variant_df['product_description'].astype(str).str.strip(),
    'product_color_code': variant_df['product_color_code'],
    'product_feature': variant_df['product_description'].astype(str).str.strip(),
    'product_installation_service_parts': None,
    'design_files': 'design_files/' + variant_df['diagram_image_name'].astype(str).str.strip() + '.pdf',
    'additional_information': variant_df['additional_image1'].astype(str).str.strip(),
})

master_final.to_excel("products_master.xlsx", index=False)
variant_final.to_excel("product_variants.xlsx", index=False)

print("✅ Done! Clean paths + final files are exported successfully.")
