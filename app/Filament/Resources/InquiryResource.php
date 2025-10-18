<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InquiryResource\Pages;
use App\Filament\Resources\InquiryResource\RelationManagers;
use App\Models\Inquiry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InquiryResource extends Resource
{
    protected static ?string $model = Inquiry::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'お問い合わせ';

    protected static ?string $modelLabel = 'お問い合わせ';

    protected static ?string $pluralModelLabel = 'お問い合わせ一覧';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('お問い合わせ内容（閲覧のみ）')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('お名前')
                            ->disabled(),
                        Forms\Components\TextInput::make('email')
                            ->label('メールアドレス')
                            ->disabled(),
                        Forms\Components\TextInput::make('phone')
                            ->label('電話番号')
                            ->disabled(),
                        Forms\Components\Select::make('category')
                            ->label('カテゴリ')
                            ->options([
                                'adoption' => '譲渡について',
                                'volunteer' => 'ボランティア',
                                'donation' => '寄付について',
                                'other' => 'その他',
                            ])
                            ->disabled(),
                        Forms\Components\TextInput::make('subject')
                            ->label('件名')
                            ->disabled(),
                        Forms\Components\Textarea::make('message')
                            ->label('メッセージ')
                            ->rows(5)
                            ->disabled(),
                        Forms\Components\Placeholder::make('created_at')
                            ->label('受信日時')
                            ->content(fn($record) => $record?->created_at?->format('Y年m月d日 H:i')),
                    ])->columns(1),

                Forms\Components\Section::make('対応情報')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('対応状況')
                            ->options([
                                'new' => '未対応',
                                'in_progress' => '対応中',
                                'resolved' => '解決済み',
                            ])
                            ->default('new')
                            ->required(),
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('管理者メモ・対応内容')
                            ->rows(5)
                            ->placeholder('対応した内容や連絡事項をメモしてください'),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('お名前')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('メールアドレス')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->label('カテゴリ')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'adoption' => 'success',
                        'volunteer' => 'info',
                        'donation' => 'warning',
                        'other' => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'adoption' => '譲渡について',
                        'volunteer' => 'ボランティア',
                        'donation' => '寄付について',
                        'other' => 'その他',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('subject')
                    ->label('件名')
                    ->limit(30)
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('対応状況')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'new' => 'danger',
                        'in_progress' => 'warning',
                        'resolved' => 'success',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'new' => '未対応',
                        'in_progress' => '対応中',
                        'resolved' => '解決済み',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('受信日時')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('カテゴリ')
                    ->options([
                        'adoption' => '譲渡について',
                        'volunteer' => 'ボランティア',
                        'donation' => '寄付について',
                        'other' => 'その他',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label('対応状況')
                    ->options([
                        'new' => '未対応',
                        'in_progress' => '対応中',
                        'resolved' => '解決済み',
                    ]),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('received_from')
                            ->label('受信日(開始)'),
                        Forms\Components\DatePicker::make('received_until')
                            ->label('受信日(終了)'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['received_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['received_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                //     Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListInquiries::route('/'),
            'create' => Pages\CreateInquiry::route('/create'),
            'edit' => Pages\EditInquiry::route('/{record}/edit'),
        ];
    }
}
