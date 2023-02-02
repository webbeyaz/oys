<?php

namespace App\Controllers\Admin\Vehicles;

use App\Controllers\Admin;
use PDO;

class Tracking extends Admin
{
	/**
	 * @return string
	 */
	public function list(): string
	{
		$events = [];
		//$images = [];

		$sql = "
			SELECT
			    e.id AS id,
			    d.firstname AS firstname,
			    d.lastname AS lastname,
			    v.plate AS plate,
			    e.text AS text,
			    e.created_at AS created_at
			FROM events e
			INNER JOIN drivers d ON d.id = e.driver_id
			INNER JOIN vehicles v ON v.id = d.vehicle_id
			WHERE e.deleted_at IS NULL
			ORDER BY e.updated_at DESC, e.id DESC
		";

		$queryEvent = $this->db->query($sql, PDO::FETCH_OBJ);

		if ($queryEvent->rowCount())
		{
			$events = $queryEvent;

			/*foreach ($queryEvent as $rowEvent)
			{
				$id = $rowEvent->id;

				$sql = "
					SELECT
					    image
					FROM images
					WHERE event_id = $id
				";

				$queryImage = $this->db->query($sql, PDO::FETCH_OBJ);

				if ($queryImage->rowCount())
				{
					foreach ($queryImage as $rowImage)
					{
						$images[$id][] = $rowImage->image;
					}
				}
			}*/
		}

		$this->data['events'] = $events;
		//$this->data['images'] = $images;

		return $this->view('admin.pages.vehicles.tracking.list', $this->data);
	}
}

/*
@if ($images)

	<div class="avatar-group">

		@foreach ($images[$event->id] as $key => $value)

			<div title="{{ $key + 1 }}" class="avatar pull-up" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="bottom">
				<img src="{{ upload_url('images/cache/events/33x33/' . $value) }}" alt="{{ $key + 1 }}" width="33" height="33">
			</div>

		@endforeach

		@if (count($images) > 4)

			<h6 class="align-self-center cursor-pointer ms-50 mb-0">
				+{{ count($images) - 4 }}
			</h6>

		@endif

	</div>

@else

	Resim yüklenmemiş.

@endif
*/
