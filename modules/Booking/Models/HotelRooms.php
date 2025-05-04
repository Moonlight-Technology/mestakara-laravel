<?php
namespace Modules\Booking\Models;

use App\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class HotelRoom extends BaseModel
{
    use SoftDeletes;

    protected $table = 'bravo_hotel_rooms';
    protected $fillable = [
        'id',
        'title',
        'parent_id',
        'number',
    ];

    /**
     * Relationship with the parent hotel (service).
     */
    public function hotel()
    {
        return $this->belongsTo(Service::class, 'parent_id');
    }

    /**
     * Scope a query to only include rooms with a specific title.
     */
    public function scopeSearchByTitle($query, $title)
    {
        return $query->where('title', 'LIKE', '%' . $title . '%');
    }

    /**
     * Retrieve data for API response.
     */
    public function dataForApi()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'parent_id' => $this->parent_id,
            'number' => $this->number,
        ];
    }
}
