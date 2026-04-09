export type Brand = {
    id: number;
    name: string;
    logo_url: string | null;
    website: string | null;
    created_at: string;
    updated_at: string;
    locations?: Location[];
    discounts?: Discount[];
};
export type BrandIndex = Brand & {
    locations_count: number;
    discounts_count: number;
};

export type Discount = {
    id: number;
    brand_id: number;
    title: string;
    description: string | null;
    expiration_date: string | null;
    user_type: number;
    created_at: string;
    updated_at: string;
    brand?: Brand;
};

export type Location = {
    id: number;
    brand_id: number;
    name: string;
    latitude: number;
    longitude: number;
    type: number;
    created_at: string;
    updated_at: string;
    brand?: Brand;
    info?: LocationInfo;
};

export type LocationInfo = {
    id: number;
    location_id: number;
    address: string;
    description: string | null;
    link: string | null;
    photo_path: string | null;
    created_at: string;
    updated_at: string;
};


export type PlatformUser = {
    id: number;
    name: string;
    email: string;
    verifi_email: string | null;
    verifi_email_verified_at: string | null;
    id_photo_path: string | null;
    is_verified: boolean;
    verifi_expiration_date: string | null;
    abonnement_expiration_date: string | null;
    created_at: string;
    updated_at: string;
};