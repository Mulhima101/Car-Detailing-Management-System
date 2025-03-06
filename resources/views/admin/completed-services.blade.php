<p class="mb-1"><strong>Created:</strong> {{ \Carbon\Carbon::parse($service->created_at)->format('M d, Y H:i') }}</p>
                                                    <p class="mb-1"><strong>Started:</strong> {{ $service->service_started_date ? \Carbon\Carbon::parse($service->service_started_date)->format('M d, Y H:i') : 'N/A' }}</p>
                                                    <p class="mb-1"><strong>Completed:</strong> {{ \Carbon\Carbon::parse($service->service_finished_date)->format('M d, Y H:i') }}</p>
                                                </div>
                                                
                                                @if($service->notes)
                                                <div class="alert alert-info mt-3">
                                                    <strong>Notes:</strong><br>
                                                    {{ $service->notes }}
                                                </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <p class="mb-0 text-muted">No completed services found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection