<?php

return new class extends Migration
{
    public function up(): void
    {
        $this->db->query(
            'CREATE TABLE students (`id` int not null auto_increment, `full_name` varchar(255), `email` varchar(255), `phone` varchar(255), primary key (id))'
        );
    }

    public function down(): void
    {
        $this->db->query(
            'DROP TABLE students'
        );
    }
};
