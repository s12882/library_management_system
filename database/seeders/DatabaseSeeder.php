<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Reader;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $authors = Author::factory(18)->create();
        $books = Book::factory(50)->recycle($authors)->create();
        $readers = Reader::factory(25)->create();

        $fullyBookedIds = $books->sortBy('total_copies')->take(5)->pluck('id');

        $books->whereIn('id', $fullyBookedIds)->each(
            fn (Book $book) => Loan::factory($book->total_copies)->recycle($readers)->create(['book_id' => $book->id])
        );

        $books->whereNotIn('id', $fullyBookedIds)->each(function (Book $book) use ($readers) {
            $loanCount = fake()->numberBetween(0, $book->total_copies);

            if ($loanCount > 0) {
                Loan::factory($loanCount)->recycle($readers)->create(['book_id' => $book->id]);
            }
        });
    }
}
