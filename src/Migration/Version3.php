<?php

namespace Snowdog\Academy\Migration;

use Snowdog\Academy\Core\Database;

class Version3
{
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function __invoke()
    {
        $this->createBorrowsTable();
    }

    private function createBorrowsTable(): void
    {
        $createQuery = <<<SQL
create table borrows (
	user_id int(11) unsigned not null,
	book_id int(11) unsigned not null,
	borrowed_at datetime null,
	primary key (user_id, book_id),
	constraint borrows_book_id_uindex
		unique (book_id),
	constraint borrows_books_id_fk
		foreign key (book_id) references books (id),
	constraint borrows_users_id_fk
		foreign key (user_id) references users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SQL;
        $this->database->exec($createQuery);
    }
}
