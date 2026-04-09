export type EnumOption<T extends Record<string, unknown> = {}> = {
    id: number;
    name: string;
} & T;

export type LocationType = EnumOption;
export type UserType = EnumOption;