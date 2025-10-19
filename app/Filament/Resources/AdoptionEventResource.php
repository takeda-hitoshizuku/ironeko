<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdoptionEventResource\Pages;
use App\Filament\Resources\AdoptionEventResource\RelationManagers;
use App\Models\AdoptionEvent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdoptionEventResource extends Resource
{
    protected static ?string $model = AdoptionEvent::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = '譲渡会';

    protected static ?string $modelLabel = '譲渡会';

    protected static ?string $pluralModelLabel = '譲渡会一覧';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('基本情報')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('タイトル')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('例: 第10回 いろねこ譲渡会'),
                        Forms\Components\Textarea::make('description')
                            ->label('詳細説明')
                            ->rows(4)
                            ->placeholder('譲渡会の内容や注意事項など'),
                    ]),

                Forms\Components\Section::make('日時')
                    ->schema([
                        Forms\Components\DatePicker::make('event_date')
                            ->label('開催日')
                            ->required(),
                        Forms\Components\TimePicker::make('start_time')
                            ->label('開始時間')
                            ->seconds(false)
                            ->required(),
                        Forms\Components\TimePicker::make('end_time')
                            ->label('終了時間')
                            ->seconds(false)
                            ->required(),
                    ])->columns(3),

                Forms\Components\Section::make('会場情報')
                    ->schema([
                        Forms\Components\TextInput::make('venue')
                            ->label('会場名')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('例: ◯◯市民センター'),
                        Forms\Components\Textarea::make('address')
                            ->label('住所')
                            ->rows(2),
                        Forms\Components\Textarea::make('access_info')
                            ->label('アクセス方法')
                            ->rows(3)
                            ->placeholder('最寄り駅、バス停、駐車場情報など'),
                    ]),

                Forms\Components\Section::make('その他')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('ステータス')
                            ->options([
                                'scheduled' => '予定',
                                'completed' => '終了',
                                'cancelled' => '中止',
                            ])
                            ->default('scheduled')
                            ->required(),
                        Forms\Components\Toggle::make('is_published')
                            ->label('公開する')
                            ->default(true),
                        Forms\Components\Textarea::make('notes')
                            ->label('注意事項・持ち物')
                            ->rows(3)
                            ->placeholder('予約不要、身分証明書持参など'),
                    ])->columns(2),

                Forms\Components\Section::make('参加予定の猫')
                    ->schema([
                        Forms\Components\CheckboxList::make('cats')
                            ->relationship('cats', 'name')
                            ->label('参加する猫を選択')
                            ->columns(3)
                            ->searchable()
                            ->bulkToggleable()
                            ->helperText('この譲渡会に参加する猫を選択してください'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('タイトル')
                    ->searchable(),
                Tables\Columns\TextColumn::make('event_date')
                    ->label('開催日')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_time')
                    ->label('開始時間')
                    ->time('H:i'),
                Tables\Columns\TextColumn::make('end_time')
                    ->label('終了時間')
                    ->time('H:i'),
                Tables\Columns\TextColumn::make('venue')
                    ->label('会場')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('ステータス')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'scheduled' => 'success',
                        'completed' => 'gray',
                        'cancelled' => 'danger',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'scheduled' => '予定',
                        'completed' => '終了',
                        'cancelled' => '中止',
                        default => $state,
                    }),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('公開')
                    ->boolean(),
                Tables\Columns\TextColumn::make('cats.name')
                    ->label('参加予定の猫')
                    ->badge()
                    ->separator(',')
                    ->limit(3),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('作成日時')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('ステータス')
                    ->options([
                        'scheduled' => '予定',
                        'completed' => '終了',
                        'cancelled' => '中止',
                    ]),
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('公開状態')
                    ->placeholder('全て')
                    ->trueLabel('公開のみ')
                    ->falseLabel('非公開のみ'),
                Tables\Filters\Filter::make('event_date')
                    ->form([
                        Forms\Components\DatePicker::make('event_from')
                            ->label('開催日(開始)'),
                        Forms\Components\DatePicker::make('event_until')
                            ->label('開催日(終了)'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['event_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('event_date', '>=', $date),
                            )
                            ->when(
                                $data['event_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('event_date', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdoptionEvents::route('/'),
            'create' => Pages\CreateAdoptionEvent::route('/create'),
            'edit' => Pages\EditAdoptionEvent::route('/{record}/edit'),
        ];
    }
}
