**NOTE:** Replace `#__` in the queries below with the prefix for your Joomla! tables.

## Run this query first
```sql
BEGIN;
INSERT INTO `#__fields_groups` (`asset_id`, `context`, `title`, `note`, `description`, `state`, `checked_out`, `checked_out_time`, `ordering`, `params`, `language`, `created`, `created_by`, `modified`, `modified_by`, `access`) VALUES
  (0, 'com_content.article', 'Custom Fields', '', '', 1, 0, '0000-00-00 00:00:00', 0, '{\"display_readonly\":\"1\"}', '*', CURRENT_TIMESTAMP, 0, '0000-00-00 00:00:00', 0, 1);
COMMIT;
```

## Run this query second
* Replace `4242` in the queries with the ID of the group you inserted in the first query.
```sql
BEGIN;
INSERT INTO `#__fields` (`asset_id`, `context`, `group_id`, `title`, `name`, `label`, `default_value`, `type`, `note`, `description`, `state`, `required`, `checked_out`, `checked_out_time`, `ordering`, `params`, `fieldparams`, `language`, `created_time`, `created_user_id`, `modified_time`, `modified_by`, `access`) VALUES
  (0, 'com_content.article', 4242, 'Info Blocks', 'info-blocks', 'Info Blocks', '', 'repeatable', '', '', 1, 0, 0, '0000-00-00 00:00:00', 0, '{\"hint\":\"\",\"class\":\"\",\"label_class\":\"\",\"show_on\":\"\",\"render_class\":\"\",\"showlabel\":\"1\",\"label_render_class\":\"\",\"display\":\"0\",\"layout\":\"\",\"display_readonly\":\"2\"}', '{\"fields\":{\"fields0\":{\"fieldname\":\"Image\",\"fieldtype\":\"media\",\"fieldfilter\":\"0\"},\"fields1\":{\"fieldname\":\"Caption Title\",\"fieldtype\":\"text\",\"fieldfilter\":\"JComponentHelper::filterText\"},\"fields2\":{\"fieldname\":\"Caption\",\"fieldtype\":\"editor\",\"fieldfilter\":\"JComponentHelper::filterText\"}}}', '*', CURRENT_TIMESTAMP, 0, '0000-00-00 00:00:00', 0, 1),
  (0, 'com_content.article', 4242, 'Supplementary Images', 'supplementary-images', 'Supplementary Images', '', 'repeatable', '', '', 1, 0, 0, '0000-00-00 00:00:00', 0, '{\"hint\":\"\",\"class\":\"\",\"label_class\":\"\",\"show_on\":\"\",\"render_class\":\"\",\"showlabel\":\"1\",\"label_render_class\":\"\",\"display\":\"0\",\"layout\":\"\",\"display_readonly\":\"2\"}', '{\"fields\":{\"fields0\":{\"fieldname\":\"Image\",\"fieldtype\":\"media\",\"fieldfilter\":\"0\"}}}', '*', CURRENT_TIMESTAMP, 0, '0000-00-00 00:00:00', 0, 1);
COMMIT;
```

```php
foreach($this->item->jcfields as $key => $field)
{
	$jcfields[$field->name] = $field;
}
```

```php
<?php if($jcfields['info-blocks']->rawvalue) : ?>
  <?php
  $registry   = new Registry($jcfields['info-blocks']->rawvalue);
  // var_dump($registry);
  $infoblocks = $registry->toArray();
  if(count($infoblocks) > 0) : ?>

  <div class="infoblocks grid-container">
    <?php foreach($infoblocks as $key => $infoblock) : ?>
      <?php $key = str_ireplace('info-blocks', '', $key); ?>
      <div class="grid-x grid-padding-x">
        <?php if($infoblock['Image']) : ?>
          <div class="infoblock__image cell small-12 medium-6 <?php echo $key%2 === 0 ? 'medium-order-2' : ''; ?>">
            <img src="<?php echo $infoblock['Image']; ?>" alt="<?php echo $this->escape($infoblock['Caption Title']); ?>" width="100%">
          </div>
        <?php endif; ?>

        <div class="infoblock__text cell auto">
          <h2><?php echo $this->escape($infoblock['Caption Title']); ?></h2>
          <p><?php echo $infoblock['Caption']; ?></p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
<?php endif; ?>
```

```php
<?php if($jcfields['supplementary-images']->rawvalue) : ?>
  <?php
  $registry   = new Registry($jcfields['supplementary-images']->rawvalue);
  // var_dump($registry);
  $infoblocks = $registry->toArray();

  if(count($infoblocks) > 0) : ?>
  <div class="article-gallery grid-container">
    <div class="grid-x grid-padding-x small-up-2 medium-up-3">
      <?php foreach($infoblocks as $key => $infoblock) : ?>
        <?php $key = str_ireplace('supplementary-images', '', $key); ?>
        <?php if($infoblock['Image']) : ?>
          <div class="cell">
            <a class="wfpopup noicon" href="<?php echo $infoblock['Image']; ?>" target="_blank" rel="noopener">
              <img src="<?php echo $infoblock['Image']; ?>" alt="<?php echo $this->escape($this->item->title); ?>" width="100%">
            </a>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endif; ?>
<?php endif; ?>
```

```css
/* .infoblocks { } */
.article-gallery.grid-container, .infoblocks.grid-container { padding-left: 0; padding-right: 0; }
.article-gallery .grid-x, .infoblocks .grid-x { align-items: center; /* background: #fefefe; */ }
.infoblock__text.cell { padding: 32px 40px; /* padding-left: 40px; padding-right: 40px; */ }
.infoblock__image.cell { align-self: stretch; padding-left: 0; padding-right: 0; }
.article-gallery .cell img, .infoblock__image img { display: block; height: 100%; object-fit: cover; object-position: center; width: 100%; }
.infoblocks h2, .infoblocks h3, .infoblocks p { margin: 0 0 8px; }
.infoblocks h2 { font-family: var(--sans-serif); font-size: 17px; font-weight: normal; line-height: normal; text-transform: uppercase; }
.infoblocks h3 { font-family: var(--sans-serif); font-size: 15px; font-weight: bold; line-height: normal; }

.article-gallery .grid-x { align-items: stretch; gap: 32px; padding: 0; }
.article-gallery .cell { margin: 0; padding: 0; }
.article-gallery .small-up-2>.cell { flex: 0 1 calc((100% / 2) - 16px); }

@media screen and (min-width: 40em) {
  .article-gallery .medium-up-3>.cell { flex: 0 1 calc((100% / 3) - 21.33px); width: unset; }
}
```
