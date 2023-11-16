<?php

return new class extends Migration
{
    public function up(): void
    {
        $this->db->query(
            'CREATE TABLE courses (`id` int not null auto_increment, `language` varchar(255) not null, primary key (id))'
        );
    }

    public function down(): void
    {
        $this->db->query(
            'DROP TABLE courses'
        );
    }
};
