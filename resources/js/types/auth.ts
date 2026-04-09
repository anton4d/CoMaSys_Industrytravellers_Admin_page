export type User = {
    id: number;
    name: string;
    email: string;
    created_at: string;
    updated_at: string;
    is_super_admin: boolean;
    can_manage_locations: boolean;
    can_manage_brands: boolean;
    can_manage_discounts: boolean;
    can_manage_users: boolean;
    can_manage_admins: boolean;
    [key: string]: unknown;
};

export type Auth = {
    user: User;
};

export type TwoFactorConfigContent = {
    title: string;
    description: string;
    buttonText: string;
};
