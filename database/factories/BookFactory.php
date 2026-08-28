<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    /**
     * Curated so seeded books read as real titles rather than Faker's Latin
     * lorem-ipsum sentences, per the task's "meaningful data" requirement.
     *
     * @var list<string>
     */
    protected static array $titles = [
        'The Silent Patient', 'A Brief History of Time', 'The Midnight Library',
        'Educated', 'The Catcher in the Rye', 'Sapiens', 'The Great Gatsby',
        'Nineteen Eighty-Four', 'Brave New World', 'The Hobbit',
        'Fahrenheit 451', 'The Alchemist', 'Crime and Punishment',
        'The Brothers Karamazov', 'War and Peace', 'Anna Karenina',
        'Pride and Prejudice', 'Jane Eyre', 'Wuthering Heights',
        'Moby-Dick', 'The Adventures of Huckleberry Finn', 'Slaughterhouse-Five',
        'The Grapes of Wrath', 'One Hundred Years of Solitude', 'The Road',
        'Blood Meridian', 'Beloved', 'Invisible Man', 'The Bell Jar',
        'Lord of the Flies', 'Animal Farm', 'The Handmaid\'s Tale',
        'Dune', 'Foundation', 'Neuromancer', 'The Left Hand of Darkness',
        'Ender\'s Game', 'The Name of the Wind', 'A Game of Thrones',
        'The Fellowship of the Ring', 'Good Omens', 'American Gods',
        'The Shining', 'It', 'Dracula', 'Frankenstein',
        'The Strange Case of Dr Jekyll and Mr Hyde', 'The Picture of Dorian Gray',
        'Meditations', 'The Origin of Species', 'Thinking, Fast and Slow',
        'Guns, Germs, and Steel', 'The Selfish Gene', 'Cosmos',
        'A People\'s History of the United States', 'The Diary of a Young Girl',
        'Man\'s Search for Meaning', 'The Art of War', 'Walden',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->randomElement(self::$titles),
            'year' => fake()->numberBetween(1500, (int) date('Y')),
            'isbn' => fake()->unique()->isbn13(),
            'author_id' => Author::factory(),
            'total_copies' => fake()->numberBetween(1, 8),
        ];
    }
}
