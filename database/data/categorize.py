import pandas as pd

df = pd.read_csv("blocks.csv")

def has(n, *keys):
    return any(k in n for k in keys)

def name_base(filename):
    return filename.lower().replace(".png", "")

def categorize(filename):
    n = name_base(filename)

    # Dimensions (prioritaires)
    if has(n, "netherrack", "crimson", "warped", "soul_", "nether", "quartz", "basalt", "blackstone"):
        return "nether"
    if has(n, "end_stone", "purpur", "chorus", "end_"):
        return "end"

    # Liquides
    if has(n, "water", "lava"):
        return "liquid"

    # Minerais / minerais du nether
    if "ore" in n or has(n, "ancient_debris"):
        return "ore"

    # Métaux / matériaux
    if has(n, "iron", "gold", "copper", "netherite", "chain"):
        return "metal"

    # Bois
    if has(n, "oak", "birch", "spruce", "jungle", "acacia", "dark_oak",
           "mangrove", "cherry", "bamboo", "planks", "log", "wood", "stem", "hyphae"):
        return "wood"

    # Pierre / minéraux
    if has(n, "stone", "cobblestone", "deepslate", "andesite", "granite",
           "diorite", "tuff", "calcite", "bricks", "slate", "sandstone",
           "prismarine", "end_stone", "terracotta", "amethyst", "blackstone"):
        return "stone"

    # Sol / terre
    if has(n, "dirt", "grass_block", "sand", "gravel", "mud", "clay", "farmland", "mycelium", "podzol"):
        return "soil"

    # Verre
    if has(n, "glass", "pane"):
        return "glass"

    # Lumière
    if has(n, "lantern", "torch", "glowstone", "shroomlight", "sea_lantern",
           "candle", "lamp", "campfire", "jack_o_lantern"):
        return "light"

    # Végétation
    if has(n, "leaves", "sapling", "flower", "grass", "fern", "crop",
           "mushroom", "fungus", "roots", "vine", "bamboo", "cactus"):
        return "plant"

    # Redstone / technique
    if has(n, "redstone", "comparator", "repeater", "observer", "piston",
           "target", "sculk", "sensor", "hopper", "dispenser", "dropper"):
        return "redstone"

    # Stockage
    if has(n, "chest", "barrel", "shulker"):
        return "storage"

    # Fonctionnels / interactifs
    if has(n, "door", "trapdoor", "button", "lever", "pressure_plate",
           "furnace", "crafting", "table", "anvil", "brewing", "loom", "smithing", "stonecutter"):
        return "functional"

    # Utility / blocs spéciaux
    if has(n, "bed", "tnt", "bookshelf", "enchant", "jukebox", "beacon", "conduit"):
        return "utility"

    # Mob / entités
    if has(n, "egg", "spawner", "mob", "creeper", "zombie", "skeleton",
           "ghast", "sniffer"):
        return "mob"

    # Décoration / couleurs
    if has(n, "concrete", "terracotta", "wool", "banner", "carpet", "glazed"):
        return "decoration"

    return "other"

def family_from_name(filename):
    n = name_base(filename)
    wood_types = [
        "acacia", "birch", "spruce", "jungle", "dark_oak",
        "mangrove", "cherry", "bamboo", "oak", "crimson", "warped"
    ]
    for w in wood_types:
        if w in n:
            return w

    stone_types = [
        "deepslate", "andesite", "granite", "diorite", "tuff", "calcite",
        "sandstone", "red_sandstone", "blackstone", "basalt", "prismarine",
        "end_stone", "amethyst", "quartz"
    ]
    for s in stone_types:
        if s in n:
            return s

    return ""

def material_from_category(category, filename):
    n = name_base(filename)
    if category == "wood":
        return "wood"
    if category == "stone":
        return "stone"
    if category == "metal":
        return "metal"
    if category == "glass":
        return "glass"
    if category == "liquid":
        return "liquid"
    if category == "plant":
        return "plant"
    if category == "soil":
        return "soil"
    if category == "ore":
        return "ore"
    if category == "redstone":
        return "redstone"
    if category == "storage" and has(n, "barrel", "chest"):
        return "wood"
    if category == "storage" and "shulker" in n:
        return "shulker"
    if category == "nether":
        return "stone"
    if category == "end":
        return "stone"
    if category == "decoration":
        return "decor"
    if category == "utility":
        return "utility"
    if category == "functional":
        return "mixed"
    if category == "storage":
        return "mixed"
    if category == "light":
        return "light"
    if category == "mob":
        return "mob"
    return ""

def detail_form(filename):
    n = name_base(filename)
    if has(n, "slab"):
        return "slab"
    if has(n, "stairs"):
        return "stairs"
    if has(n, "wall"):
        return "wall"
    if has(n, "pillar", "log", "stem", "hyphae"):
        return "pillar"
    if has(n, "pane"):
        return "pane"
    if has(n, "fence_gate"):
        return "fence_gate"
    if has(n, "fence"):
        return "fence"
    if has(n, "trapdoor"):
        return "trapdoor"
    if has(n, "door"):
        return "door"
    if has(n, "button"):
        return "button"
    if has(n, "pressure_plate"):
        return "pressure_plate"
    if has(n, "torch"):
        return "torch"
    if has(n, "lantern"):
        return "lantern"
    if has(n, "sign"):
        return "sign"
    if has(n, "bed"):
        return "bed"
    if has(n, "rail"):
        return "rail"
    if has(n, "carpet"):
        return "carpet"
    return "block"

def detail_flammable(filename, category):
    n = name_base(filename)
    if category in ["wood", "plant"]:
        return True
    if has(n, "wool", "carpet", "leaves", "sapling", "banner"):
        return True
    return False

def detail_interactive(filename):
    n = name_base(filename)
    return has(
        n,
        "door", "trapdoor", "button", "lever", "pressure_plate",
        "furnace", "crafting", "table", "anvil", "chest", "barrel",
        "shulker", "bed", "jukebox", "enchant", "brewing", "loom",
        "smithing", "stonecutter", "hopper", "dispenser", "dropper"
    )

df["category"] = df["file_name"].apply(categorize)
df["family"] = df["file_name"].apply(family_from_name)
df["material"] = df.apply(lambda r: material_from_category(r["category"], r["file_name"]), axis=1)
df["is_transparent"] = df["category"].isin(["glass", "liquid"])
df["is_solid"] = ~df["category"].isin(["liquid"])

# 3 colonnes de détail demandées
df["detail_form"] = df["file_name"].apply(detail_form)
df["detail_flammable"] = df.apply(lambda r: detail_flammable(r["file_name"], r["category"]), axis=1)
df["detail_interactive"] = df["file_name"].apply(detail_interactive)

# Remplissage pour éviter les valeurs vides (évite ",," dans le CSV)
df["family"] = df["family"].replace("", pd.NA).fillna(df["category"])
df["material"] = df["material"].replace("", pd.NA).fillna("other")

df.to_csv("blocks_extended.csv", index=False)

print("OK : blocks_extended.csv généré proprement")
