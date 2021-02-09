
class Message {
    id: number;
    user_id: number;
    message: string;
    created_at: Date;
    updated_at: Date;
}

class Link {
    url: URL;
    label: string;
    active: boolean;
}
export class Paginate {
    current_page: number;
    data: Message[];
    first_page_url: URL;
    from?: number;
    last_page: number;
    last_page_url: string;
    links: Link[];
    next_page_url?: URL;
    path: string;
    per_page: number;
    prev_page_url?: URL;
    to?: number;
    total: number;
}

export { };