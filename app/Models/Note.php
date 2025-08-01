<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'content', 'pic_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function picture()
    {
        return $this->belongsTo(Picture::class, 'pic_id');
    }


    public static function getUserNotes($userId, $search = null, $perPage = 5)
    {
        return self::with('picture')
            ->where('user_id', $userId)
            ->when($search, function ($query, $search) {
                return $query->where('content', 'like', "%{$search}%");
            })
            ->latest('updated_at')
            ->paginate($perPage);
    }

    public static function createNote($userId, $content, $picId = null)
    {
        return self::create([
            'user_id' => $userId,
            'content' => $content,
            'pic_id'  => $picId,
        ]);
    }

public function updateNote($content, $pic_id = null)
{
    $data = ['content' => $content];

    if ($pic_id !== null) {
        $data['pic_id'] = $pic_id;
    }

    return $this->update($data);
}

    public function deleteNote()
    {
        return $this->delete();
    }

    public static function searchNotes($query = null)
    {
        if ($query && strlen($query) >= 3) {
            return self::with('picture')->where('content', 'like', "%{$query}%")->latest('updated_at')->get();
        }

        return self::all();
    }
}
