<?php

namespace Tests\Feature;

use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test create tiket baru.
     */
    public function test_can_create_new_ticket(): void
    {
        $response = $this->post(route('tickets.store'), [
            '_token' => csrf_token(),
            'title' => 'Bug pada halaman login',
            'description' => 'Tombol submit tidak berfungsi.',
            'status' => 'open',
            'priority' => 'high',
        ]);

        $response->assertRedirect(route('tickets.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('tickets', [
            'title' => 'Bug pada halaman login',
            'description' => 'Tombol submit tidak berfungsi.',
            'status' => 'open',
            'priority' => 'high',
        ]);
    }

    /**
     * Test view detail tiket.
     */
    public function test_can_view_ticket_detail(): void
    {
        $ticket = Ticket::create([
            'title' => 'Tiket untuk testing',
            'description' => 'Deskripsi tiket.',
            'status' => 'open',
            'priority' => 'medium',
        ]);

        $response = $this->get(route('tickets.show', $ticket));

        $response->assertStatus(200);
        $response->assertSee('Tiket untuk testing');
        $response->assertSee('Deskripsi tiket.');
    }

    /**
     * Test update tiket.
     */
    public function test_can_update_ticket(): void
    {
        $ticket = Ticket::create([
            'title' => 'Judul lama',
            'description' => 'Deskripsi lama',
            'status' => 'open',
            'priority' => 'low',
        ]);

        $response = $this->put(route('tickets.update', $ticket), [
            '_token' => csrf_token(),
            '_method' => 'PUT',
            'title' => 'Judul diperbarui',
            'description' => 'Deskripsi diperbarui',
            'status' => 'resolved',
            'priority' => 'high',
        ]);

        $response->assertRedirect(route('tickets.show', $ticket));
        $response->assertSessionHas('success');

        $ticket->refresh();
        $this->assertSame('Judul diperbarui', $ticket->title);
        $this->assertSame('resolved', $ticket->status);
    }

    /**
     * Test delete tiket.
     */
    public function test_can_delete_ticket(): void
    {
        $ticket = Ticket::create([
            'title' => 'Tiket akan dihapus',
            'description' => 'Deskripsi',
            'status' => 'open',
            'priority' => 'medium',
        ]);

        $response = $this->delete(route('tickets.destroy', $ticket), [
            '_token' => csrf_token(),
            '_method' => 'DELETE',
        ]);

        $response->assertRedirect(route('tickets.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('tickets', ['id' => $ticket->id]);
    }

    /**
     * Test validasi saat create (title required).
     */
    public function test_create_validates_required_fields(): void
    {
        $response = $this->post(route('tickets.store'), [
            '_token' => csrf_token(),
            'title' => '',
            'status' => 'open',
            'priority' => 'medium',
        ]);

        $response->assertSessionHasErrors('title');
        $this->assertDatabaseCount('tickets', 0);
    }

    /**
     * Test validasi saat update.
     */
    public function test_update_validates_required_fields(): void
    {
        $ticket = Ticket::create([
            'title' => 'Judul',
            'status' => 'open',
            'priority' => 'medium',
        ]);

        $response = $this->put(route('tickets.update', $ticket), [
            '_token' => csrf_token(),
            '_method' => 'PUT',
            'title' => '',
            'status' => 'open',
            'priority' => 'medium',
        ]);

        $response->assertSessionHasErrors('title');
    }
}
