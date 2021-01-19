<?php

namespace App\Models;

use App\Enums\Duration;
use App\Enums\productStatus;
use App\Events\ProductPublished;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Product extends Model
{
	use HasFactory;
	protected $table = 'products';
	protected $fillable = [
		'status', 'name', 'description', 'price', 'photo',
	];

	protected $with = 'owner:id,name';


	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'created_at' => 'datetime',
	];

	public function categories()
	{
		return $this->belongsToMany($this->categoryModel, 'category_product', 'product_id', 'category_id');
	}
	public function variations()
	{
		return $this->hasMany($this->productVariationModel, 'product_id')->orderBy('order', 'asc');
	}
	public function types()
	{
		return $this->hasMany($this->productVariationTypeModel, 'product_id');
	}
	public function carts()
	{
		return $this->hasMany($this->cartModel, 'product_id');
	}
	public function wishlists()
	{
		return $this->hasMany($this->wishlistModel, 'product_id');
	}
	public function owner()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
	public function shouldBeReviewed()
	{
		return !!config('market.product.review');
	}
	protected function activeSalesFor($relation)
	{
		return $this->whereHas("$relation.sales", function ($query) {
			return $query->where('sales.expires_at', '>', Carbon::now()->format('Y-m-d H:i:s'));
		})->get();
	}
	protected function sumSalesFor($relation)
	{
		return $this->activeSalesFor($relation)->reduce(function ($carry, $relation) {
			return $carry + $relation->getDiscount();
		});
	}
	public function activeSales()
	{
		return $this->sales()->where('expires_at', '>', Carbon::now()->format('Y-m-d H:i:s'))->orWhereNull('expires_at')->get();
	}
	public function getDiscount()
	{
		if (!$this->sale) {
			$this->sale = $this->sumSalesFor('categories') + $this->sumSalesFor('types') + $this->activeSales()->sum('percentage');
		}
		return $this->sale;
	}
	public function getHasSaleAttribute()
	{
		return $this->getDiscount() > 0;
	}
	public function getSaleAttribute()
	{
		if ($this->has_sale) {
			return $this->sale;
		}
		return 0;
	}
	public function setOfferAttribute($newValue)
	{

		$it_1 = json_decode($newValue, TRUE) ?? [];
		$it_2 = json_decode($this->offer, TRUE) ?? [];
		$result_array = array_diff($it_1, $it_2);
		if (empty($result_array[0])) {
			// dump($result_array);
			dump("We have a new offer ");
			$this->attributes['offer'] = $newValue;
			$this->status = productStatus::Published();
			if ($it_1['PremOffer']) {
				$this->status = productStatus::paidPublished();
			}
			if ($it_1['timeOffer']) {
				switch ($it_1['timeData'][1]) {
					case Duration::Day():
						$t = Carbon::now()->addDays($it_1['timeData'][0]);
						break;
					case Duration::Month():
						$t = Carbon::now()->addMonth($it_1['timeData'][0]);
						break;
					case Duration::Week():
						$t = Carbon::now()->addWeek($it_1['timeData'][0]);
						break;
					case Duration::Hour():
						$t = Carbon::now()->addHour($it_1['timeData'][0]);
						break;
					default:
						dd('Error with TimeData of offer');
						break;
				}
				$this->offer_at = $t;
			}
			$this->offer_at = Carbon::now();
			ProductPublished::dispatchIf(
				$this->isDirty(),
				$this->id
			);
			$this->save();
		}
	}
}
